<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->map(function($item) {
            return [
                'id' => $item['id'],
                'product_code' => $item['product_code'],
                'name' => $item['name'],
                'description' => $item['description'] ? $item['description'] : '',
                'unit' => $item['unit'],
                'price' => $item['price'],
                'discount_price' => $item['discount_price'] ? $item['discount_price'] : '',
                'preview_images' => $item['preview_images'],
                'featured_images' => $item['featured_images'],
                'category_id' => $item['category_id'],
                'category_name' => $item->category ? $item->category->name : '',
                'provider_id' => $item['provider_id'],
                'provider_name' => $item->provider ? $item->provider->name : ''
            ];
        });
        return response()->json(['data' => $products], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        if ($request->input('discount_price') &&
            ($request->input('discount_price') > $request->input('price'))) {
            return response(['message' => 'price must be greater than discount price'], 433);
        }

        \DB::beginTransaction();
        try {
            $product = Product::create($request->all());
            \DB::commit();
            return response([ 'data' => $product ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response(['message' => 'Failed'], 433);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!$product) {
            return response(['message' => 'Invalid param'], 433);
        }

        $data = [
            'id' => $product['id'],
            'product_code' => $product['product_code'],
            'name' => $product['name'],
            'description' => $product['description'],
            'unit' => $product['unit'],
            'price' => $product['price'],
            'discount_price' => $product['discount_price'],
            'preview_images' => $product['preview_images'],
            'featured_images' => $product['featured_images'],
            'category_id' => $product['category_id'],
            'category_name' => $product->category->name,
            'provider_id' => $product['provider_id'],
            'provider_name' => $product->provider->name
        ];

        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {
        if (!$product) {
            return response(['message' => 'Invalid param'], 433);
        }

        if ($request->input('discount_price') &&
            ($request->input('discount_price') > $request->input('price'))) {
            return response(['message' => 'price must be greater than discount price'], 433);
        }

        \DB::beginTransaction();
        try {
            $product->update($request->all());
            \DB::commit();
            return response([ 'data' => $product ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response(['message' => 'Failed'], 433);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!$product) {
            return response(['message' => 'Invalid param'], 433);
        }

        \DB::beginTransaction();
        try {
            $product->delete();
            \DB::commit();

            $products = Product::all()->map(function($item) {
                return [
                    'id' => $item['id'],
                    'product_code' => $item['product_code'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'discount_price' => $item['discount_price'],
                    'preview_images' => $item['preview_images'],
                    'featured_images' => $item['featured_images'],
                    'category' => [
                        'id' => $item['category_id'],
                        'name' => $item->category->name
                    ],
                    'provider' => [
                        'id' => $item['provider_id'],
                        'name' => $item->provider->name
                    ],
                ];
            });
            return response([ 'data' => $products ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response(['message' => 'Failed'], 433);
        }
    }
}
