<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        // $user = Auth::user(); // Get the authenticated user
        // $user = auth()->user(); // Alternative way to get the authenticated user

        $companies = Company::all();
        return CompanyResource::collection($companies);
    }

    public function create_company(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:companies,email',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|boolean',
            'expire_date' => 'nullable|date',
            'play_store_link' => 'nullable|url',
            'app_store_link' => 'nullable|url',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $company = new Company();
        $company->owner_name = $request->owner_name;
        $company->company_name = $request->company_name;
        $company->contact = $request->contact;
        $company->email = $request->email;
        $company->password = $request->password;
        $company->address = $request->address;
        $logo = $request->logo;
        $company->status = $request->status;
        $company->expire_date = $request->expire_date ?: null;
        $company->play_store_link = $request->play_store_link;
        $company->app_store_link = $request->app_store_link;
        if($logo)
        {
            $file_name = time().'.'.$logo->getClientOriginalExtension();
            $logo->move('images', $file_name);
            $company->logo = 'images/'.$file_name;
        }
        $company->save();
        // return response()->json($company);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Company created successfully'
        ]);
    }

    public function update_company(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('companies')->ignore($id),
            ],
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|boolean',
            'expire_date' => 'nullable|date',
            'play_store_link' => 'nullable|url',
            'app_store_link' => 'nullable|url',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $company = Company::find($id);
        if(!$company)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $company->owner_name = $request->owner_name;
        $company->company_name = $request->company_name;
        $company->contact = $request->contact;
        $company->email = $request->email;
        $company->password = $request->password;
        $company->address = $request->address;
        $logo = $request->logo;
        $company->status = $request->status;
        $company->expire_date = $request->expire_date ?: null;
        $company->play_store_link = $request->play_store_link;
        $company->app_store_link = $request->app_store_link;
        if($logo)
        {
            $file_name = time().'.'.$logo->getClientOriginalExtension();
            $logo->move('images', $file_name);
            $company->logo = 'images/'.$file_name;
        }
        $company->save();
        // return response()->json($company);
        return response()->json([
            'Status' => 'Success',
            'message' => 'Company updated successfully'
        ]);
    }

    public function delete_company($id)
    {
        $company = Company::find($id);
        if(!$company)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Invalid request!'
            ], 404);
        }

        $company->delete();
        return response()->json([
            'Status' => 'Success',
            'message' => 'Company deleted successfully'
        ]);
    }

}
