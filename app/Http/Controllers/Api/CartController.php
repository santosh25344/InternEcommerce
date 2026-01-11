<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
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
        $carts = Cart::all();
        return CartResource::collection($carts);
    }

    public function add_to_cart(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'nullable',
            'product_id' => 'nullable',
            'qty' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        }

        $cart = new Cart();
        $cart->user_id = $request->user_id;
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->amount = $request->amount;
        $cart->save();
        return response()->json([
            'status' => "Success",
            'message' => "Product added to cart successfully",
        ]);
    }

    public function update_cart(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'nullable',
            'product_id' => 'nullable',
            'qty' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        }

        $cart = Cart::find($id);
        $cart->user_id = $request->user_id;
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->amount = $request->amount;
        $cart->save();
        return response()->json([
            'status' => "Success",
            'message' => "Product updated in cart successfully",
        ]);
    }

    public function delete_cart($id)
    {
        $cart = Cart::find($id);
        if(!$cart)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request',
            ]);
        }

        $user = auth()->user();
        if($user !== 'admin')
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'You are not authorized',
            ]);
        }

        $cart->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Product removed from cart successfully',
        ]);
    }
}
