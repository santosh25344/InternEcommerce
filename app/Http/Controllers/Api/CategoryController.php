<?php

namespace App\Http\Controllers\Api;

use App\Filament\Resources\Categories\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->slug = $request->slug;
        $category->save();
        // return response()->json($category);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Category created successfully'
        ]);
    }

    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }
}
