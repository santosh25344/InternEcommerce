<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        // $user = Auth::user(); // Get the authenticated user
        // $user = auth()->user(); // Alternative way to get the authenticated user

        $clients = Client::all();
        return ClientResource::collection($clients);
    }

    public function create_client(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shop_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
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
        $logo = $request->logo;
        $client->status = $request->status;
        $client->expire_date = $request->expire_date ?: null;
        if($logo)
        {
            $file_name = time().'.'.$logo->getClientOriginalExtension();
            $logo->move('images', $file_name);
            $client->logo = 'images/'.$file_name;
        }
        $client->save();
        // return response()->json($client);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Client created successfully'
        ]);
    }

    public function update_client(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'shop_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clients')->ignore($id),
            ],
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|boolean',
            'expire_date' => 'nullable|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::find($id);
        if(!$client)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $client = Client::find($id);
        $client->name = $request->name;
        $client->shop_name = $request->shop_name;
        $client->contact = $request->contact;
        $client->email = $request->email;
        $client->password = $request->password;
        $client->address = $request->address;
        $logo = $request->logo;
        $client->status = $request->status;
        $client->expire_date = $request->expire_date ?: null;
        if($logo)
        {
            $file_name = time().'.'.$logo->getClientOriginalExtension();
            $logo->move('images', $file_name);
            $client->logo = 'images/'.$file_name;
        }
        $client->save();
        // return response()->json($client);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Client updated successfully'
        ]);
    }

    public function delete_client($id)
    {
        $client = Client::find($id);
        if(!$client)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $client->delete();
        return response()->json([
            'Status' => 'Success',
            'message' => 'Client deleted successfully'
        ]);
    }

}
