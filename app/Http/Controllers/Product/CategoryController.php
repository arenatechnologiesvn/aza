<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    private $categories_validation = [
        'code' => 'required|max:255',
        'name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
        'description'=> 'string|max:500'
    ];

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
        return response()->json(['data' => $categories], 200);
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
        $data = $request->validate($this->categories_validation);

        $category = Category::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'icon' => $data['icon'],
            'description' => $data['description'],
        ]);

        if (!$category) {
            return response(['data' => ['message' => 'fail']], 433);
        }

        return response([ 'data' => $category], 200);
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
    public function update(Request $request, Category $category)
    {
        if (!$category) {
            return response(['message' => 'Invalid param'], 433);
        }

        $data = $request->validate($this->categories_validation);

        $category['code'] = $data['code'];
        $category['name'] = $data['name'];
        $category['icon'] = $data['icon'];
        $category['description'] = $data['description'];
        $category->save();

        return response([ 'data' => $category], 200);
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
