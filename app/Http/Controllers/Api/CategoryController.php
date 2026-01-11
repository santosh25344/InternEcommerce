<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if($user->role !== 'admin')
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'You are not authorized',
            ]);
        }
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

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

    public function update_category(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($id),
            ],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->slug = $request->slug;
        $category->save();
        // return response()->json($category);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Category updated successfully'
        ]);
    }

    public function delete_category($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!',
            ]);
        }
        $category->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Category deleted successfully',
        ]);
    }
}
