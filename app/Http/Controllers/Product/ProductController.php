<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $data = $request->validate([
            'product_code' => 'required|unique:products|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discountPrice' => 'numeric',
            'unit' => 'required|string|max:255',
            'imageUrl'=> 'required|string|max:500',
            'categoryId' => 'required|exists:categories,id',
            'providerId' => 'required|exists:providers,id',
            'description'=> 'string|max:500',
        ]);

        $product = Product::create([
            'product_code' => $data['product_code'],
            'name' => $data['name'],
            'description' => $data['description'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'discount_price' => $data['discountPrice'],
            'preview_images' => $data['imageUrl'],
            'featured_images' => $data['imageUrl'],
            'category_id' => $data['categoryId'],
            'provider_id' => $data['providerId']
        ]);

        if (!$product) {
            return response(['message' => 'Store product failed'], 433);
        }

        return response(['message' => 'success'], 200);
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
            'provider_id' => $product['provider_id']
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
    public function update(Request $request, Product $product)
    {
        //
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

        $product->delete();
        $refresh_products = Product::all()->map(function($item) {
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

        return response()->json(['data' => $refresh_products], 200);
    }
}
