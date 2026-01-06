<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function create_client(Request $request)
    {
        // return response()->json($request);
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
        return response()->json($client);
        // return $client;
    }
}
