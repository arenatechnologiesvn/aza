<?php

namespace App\Service;

use App\Helper\RoleConstant;
use App\Product;
use App\Category;
use App\Provider;
use App\Order;
use App\ProductOrder;
use App\Service\MediaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

define("ORDER_CONFIRM_STATUS", 1);
define("ORDER_PROCESSING_STATUS", 3);

class ProductService extends BaseService
{
    protected $selectable = [
        'id',
        'product_code',
        'name',
        'description',
        'unit',
        'quantitative',
        'price',
        'discount_price',
        'featured_image',
        'category_id',
        'provider_id'
    ];

    public function __construct(Product $model, MediaService $mediaService)
    {
        $this->model = $model;
        $this->mediaService = $mediaService;
        parent::__construct($model);
    }

    /*
    * Get All Product for home with favorite and card of customers
    * */

    public function getAllProducts()
    {
        /*
          Select by orm
        */
        if (Auth::user()->role_id == RoleConstant::Customer) {
            return $this->model->with(['customerFavorites' => function ($q) {
                $q->select(['id']);
            },'customerCarts' => function ($q) {
                $q->select(['id']);
            },'category', 'provider', 'featured' => function ($q3) {
                $q3->select(
                    DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                );
            },'previews'=> function ($q3) {
                $q3->select([
                    'id',
                    DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                ]);
            } ])->get();
        } else {
            /*
          Maping
        */
            $products = $this->model->get()->map(function ($item) {
                return $this->transformData($item);
            });
            return $products;
        }


    }

    public function getProductById($id)
    {
        if (Auth::user()->role_id == RoleConstant::Customer) {
            return $this->model->with($this->relative())->find($id);
        } else {
             if (!$product = $this->model::find($id)) {
                 throw new \Exception('Product is not exist');
             }
             return $this->transformData($product);
        }


    }

    public function getProductByCategory($categoryId)
    {
        if (!$products = $this->model::where('category_id', $categoryId)->get()) {
            throw new \Exception('Product is not exist');
        }

        return $products->map(function ($item) {
            return $this->transformData($item);
        });
    }

    public function storeProduct($params)
    {
        try {
            \DB::beginTransaction();

            $product = $this->model::create($params);
            if (isset($params['featured_image'])) {
                $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');
            }

            if (isset($params['preview_images'])) {
                $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');
            }

            \DB::commit();
            return $product;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function bulkStoreProduct($params)
    {
        try {
            \DB::beginTransaction();

            foreach ($params as $data) {
                if (!$this->isValidBulkStore($data)) {
                    throw new \Exception('Dữ liệu tải lên không hợp lệ. Làm ơn kiểm tra lại');
                }

                if ($product = $this->model->where('product_code', '=', $data['product_code'])->first()) {
                    throw new \Exception('Sản phẩm #' . $product->product_code . ' đã tồn tại');
                }

                if ($data['category_code'] && !$category = Category::where('code', '=', $data['category_code'])->first()) {
                    throw new \Exception('Danh mục #' . $data['category_code'] . ' không tồn tại');
                }

                if ($data['provider_code'] && !$provider = Provider::where('code', '=', $data['provider_code'])->first()) {
                    throw new \Exception('Nhà cung cấp #' . $data['provider_code'] . ' không tồn tại');
                }

                $this->model::create([
                    'product_code' => $data['product_code'],
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'unit' => $data['unit'],
                    'quantitative' => $data['quantitative'],
                    'category_id' => isset($category) ? $category['id'] : null,
                    'provider_id' => isset($provider) ? $provider['id'] : null,
                    'note' => $data['note']
                ]);
            }

            \DB::commit();
            return $product;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function updateProduct($product, $params)
    {
        try {
            \DB::beginTransaction();

            if (isset($params['price']) && $product['price'] != $params['price']) {
                $this->updateOrderProductPrice($product['id'], $params['price']);
            }

            $product->update($params);
            if (isset($params['featured_image'])) {
                $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');
            }

            if (isset($params['preview_images'])) {
                $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');
            }

            \DB::commit();
            return $product;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function deleteProduct($id)
    {
        $this->destroy($id);
    }

    /*================= PRIVATE FUNCTIONS =================*/

    private function transformData($data)
    {
        $featured_image = $this->mediaService->getMedia($data, 'featured')->first();
        $preview_images = $this->mediaService->getMedia($data, 'preview')->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => '/' . $media->directory . '/' . $media->filename . '.' .  $media->extension
            ];
        });

        return [
            'id' => $data['id'],
            'product_code' => $data['product_code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'unit' => $data['unit'],
            'quantitative' => $data['quantitative'],
            'price' => $data['price'],
            'discount_price' => $data['discount_price'],
            'preview_images' => $preview_images,
            'featured_image' => $featured_image ? [
                'id' => $featured_image->id,
                'url' => '/' . $featured_image->directory . '/' . $featured_image->filename . '.' .  $featured_image->extension
            ] : null,
            'category_id' => $data['category_id'],
            'category' => $data->category,
            'provider_id' => $data['provider_id'],
            'provider' => $data->provider
        ];
    }

    private function relative() {
        $relatives = ['category', 'provider', 'featured','previews'];
        if(Auth::user()->role_id == RoleConstant::Customer){
            array_push($relatives, ['customerFavorites' => function ($q) {
                $q->select(['id']);
            }, 'customerCarts']);
        }
        return $relatives;
    }

    private function updateOrderProductPrice($product_id, $newPrice)
    {
        try {
            \DB::beginTransaction();

            $updatableOrders = Order::whereIn('status', [ORDER_CONFIRM_STATUS, ORDER_PROCESSING_STATUS])->get();
            foreach ($updatableOrders as $order) {
                if ($target = ProductOrder::where([
                    ['order_id', '=', $order->id],
                    ['product_id', '=', $product_id]
                ])) {
                    $target->update([
                        'tmp_price' => $newPrice,
                        'real_price' => $newPrice
                    ]);
                    $this->updateTotal($order->id);
                }
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function updateTotal ($order_id)
    {
        try {
            \DB::beginTransaction();

            $total = DB::table('order_product')
                ->select([
                    DB::raw('SUM(quantity * real_price) as total')
                ])->where('order_id', '=', $order_id)->get()->first()->total;
            DB::table('orders')
                ->where('id', $order_id)
                ->update(['total_money'=> $total ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function isValidBulkStore($data) {
        return isset($data['product_code']) &&
            isset($data['name']) &&
            isset($data['price']) &&
            isset($data['unit']) &&
            isset($data['quantitative']) &&
            (isset($data['category_code']) || array_key_exists('category_code', $data)) &&
            (isset($data['provider_code']) || array_key_exists('provider_code', $data)) &&
            (isset($data['note']) || array_key_exists('note', $data));
    }
}
