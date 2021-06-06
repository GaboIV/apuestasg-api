<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::all();

        return $this->successResponse([
            'categories' => $categories
        ], 200);
    }
}
