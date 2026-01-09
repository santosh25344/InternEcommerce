<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return PaymentResource::collection($payments);
    }

    public function process_payment(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'nullable',
            'order_id' => 'nullable',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $payment = new Payment();
        $payment->user_id = $request->user_id;
        $payment->order_id = $request->order_id;
        $payment->payment_method = $request->payment_method;
        $payment->status = $request->status;
        $payment->amount = $request->amount;
        $payment->save();
        return response()->json([
            'status' => 'Success',
            'message' => "Payment processed successfully",
        ]);
   }

   public function edit_payment(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'nullable',
            'order_id' => 'nullable',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $payment = Payment::find($id);
        $payment->user_id = $request->user_id;
        $payment->order_id = $request->order_id;
        $payment->payment_method = $request->payment_method;
        $payment->status = $request->status;
        $payment->amount = $request->amount;
        $payment->save();
        return response()->json([
            'status' => 'Success',
            'message' => "Payment edited successfully",
        ]);
   }

   public function delete_payment($id)
   {
       $payment = Payment::find($id);
       if(!$payment)
       {
           return response()->json([
               'status' => 'error',
               'message' => 'Invalid Payment ID'
           ], 404);
       }
       $payment->delete();
       return response()->json([
           'status' => 'Success',
           'message' => 'Payment deleted successfully'
       ]);
   }
}
