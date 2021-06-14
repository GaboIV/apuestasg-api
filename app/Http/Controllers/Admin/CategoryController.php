<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Categories\CategoryRequest;

class CategoryController extends ApiController
{
    public function index(Request $request)
    {
        if (request()->page) {
            $categories = Category::filterByColumns($request->all())
            ->orderBy('id', 'desc')->paginate(20);
        } else {
            $categories = Category::all();
        }

        return $this->successResponse([
            'categories' => $categories
        ], 200);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = Category::create($data);

        return $this->successResponse($category, 200);
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        Category::whereId($id)->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }
}
