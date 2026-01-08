<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        if(!$orders)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'No orders found'
            ], 404);
        }

        return response()->json($orders);
    }

    public function create_order(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'delivery_address' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        };

        $order = new Order();
        $order->total_amount = $request->total_amount;
        $order->status = $request->status;
        $order->delivery_address = $request->delivery_address;
        $order->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Order created successfully'
        ]);
    }

    public function update_order(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'delivery_address' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors(),
            ]);
        };

        $order = Order::find($id);
        $order->total_amount = $request->total_amount;
        $order->status = $request->status;
        $order->delivery_address = $request->delivery_address;
        $order->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'Order updated successfully'
        ]);
    }

    public function delete_order($id)
    {
        $order = Order::find($id);
        if(!$order)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $order->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Order deleted successfully'
        ]);
    }
}
