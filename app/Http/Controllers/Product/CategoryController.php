<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all()->map(function($item) {
            return [
                'id' => $item['id'],
                'code' => $item['code'],
                'name' => $item['name'],
                'icon' => $item['icon'],
                'description' => $item['description']
            ];
        });

        return $this->api_success_response(['data' => $categories]);
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
    public function store(StoreCategory $request)
    {
        $category = Category::create($request->all());

        \DB::beginTransaction();
        try {
            $category = Category::create($request->all());
            \DB::commit();
            return response([ 'data' => $category ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response(['message' => $e], 433);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!$category) {
            return response(['message' => 'Invalid param'], 433);
        }

        $data = [
            'id' => $category['id'],
            'code' => $category['code'],
            'name' => $category['name'],
            'icon' => $category['icon'],
            'description' => $category['description']
        ];

        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, Category $category)
    {
        if (!$category) {
            return response(['message' => 'Invalid param'], 433);
        }

        \DB::beginTransaction();
        try {
            $category->update($request->all());
            \DB::commit();
            return response([ 'data' => $category ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response(['message' => 'Failed'], 433);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!$category) {
            return response(['message' => 'Invalid param'], 433);
        }

        $category->delete();
        $categories = Category::all()->map(function($item) {
            return [
                'id' => $item['id'],
                'code' => $item['code'],
                'name' => $item['name'],
                'description' => $item['description']
            ];
        });

        return response()->json(['data' => $categories], 200);
    }
}
