<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function create_client(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shop_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'logo' => 'nullable|string',
            'status' => 'required|boolean',
            'expire_date' => 'nullable|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $client = new Client();
        $client->name = $request->name;
        $client->shop_name = $request->shop_name;
        $client->contact = $request->contact;
        $client->email = $request->email;
        $client->password = $request->password;
        $client->address = $request->address;
        $client->logo = $request->logo;
        $client->status = $request->status;
        $client->expire_date = $request->expire_date ?: null;
        $client->save();
        // return response()->json($client);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Client created successfully'
        ]);
    }

    public function index()
    {
        $clients = Client::all();
        return ClientResource::collection($clients);
    }
}
