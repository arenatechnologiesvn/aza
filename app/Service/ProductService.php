<?php

namespace App\Service;

use App\Helper\RoleConstant;
use App\Product;
use App\Service\MediaService;
use Illuminate\Support\Facades\Auth;

class ProductService extends BaseService
{
    protected $selectable = [
        'id',
        'product_code',
        'name',
        'description',
        'unit',
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
         return $this->model->with($this->relative())->get();
        /* 
          Maping
        */
//        $products = $this->model->get()->map(function ($item) {
//            return $this->transformData($item);
//        });
//
//        return $products;
    }

    public function getProductById($id)
    {
        if (!$product = $this->model::find($id)) {
            throw new \Exception('Product is not exist');
        }

        return $this->transformData($product);
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
            if ($params['featured_image']) {
                $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');
            }

            if ($params['preview_images']) {
                $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');
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

            $product->update($params);
            if ($params['featured_image']) {
                $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');
            }
            $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');

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
            'provider' => $data->provider,
            // 'customerFavorites'=> $data->customerFavorites->where('user_id', '=', Auth::user()->id),
            // 'preview' => $data->preview
        ];
    }

    private function relative() {
        $relatives = ['category', 'provider', 'featured','previews'];
        if(Auth::user()->role_id == RoleConstant::Customer){
            array_push($relatives, 'customerFavorites', 'customerCarts');
        }
        return $relatives;
    }
}
