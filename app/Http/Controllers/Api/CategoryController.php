<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create_category(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->slug = $request->slug;
        $category->save();
        return response()->json($category);
    }
}
