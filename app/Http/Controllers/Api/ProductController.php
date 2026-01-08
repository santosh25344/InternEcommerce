<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function create_product(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'price' => 'required|decimal:2',
            'discount_price' => 'nullable|decimal:2',
            'stock_quantity' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->is_active = $request->is_active;
        $product->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Product created successfully'
        ]);

    }

    public function update_product(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($id),],
            'price' => 'required|decimal:2',
            'discount_price' => 'nullable|decimal:2',
            'stock_quantity' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->is_active = $request->is_active;
        $product->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Product updated successfully'
        ]);

    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Product deleted successfully'
        ]);
    }
}
