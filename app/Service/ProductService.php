<?php

namespace App\Service;

use App\Product;
use App\Service\MediaService;

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

    public function getAllProducts()
    {
        $products = $this->model::all()->map(function($item) {
            return $this->transformData($item);
        });

        return $products;
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

        return $products->map(function($item) {
            return $this->transformData($item);
        });
    }

    public function storeProduct($params)
    {
        try {
            \DB::beginTransaction();

            $product = $this->model::create($params);
            $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');
            $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');

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
            $this->mediaService->syncMedia($product, $params['preview_images'], 'preview');
            $this->mediaService->syncMedia($product, $params['featured_image'], 'featured');

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
        return [
            'id' => $data['id'],
            'product_code' => $data['product_code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'discount_price' => $data['discount_price'],
            'preview_images' => $this->mediaService->getMedia($data, 'preview'),
            'featured_image' => $this->mediaService->getMedia($data, 'featured'),
            'category_id' => $data['category_id'],
            'category' => $data->category,
            'provider_id' => $data['provider_id'],
            'provider' => $data->provider
        ];
    }
}
