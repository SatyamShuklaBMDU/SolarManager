<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:255|unique:users,phone_number',
            'whatsapp_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'pincode' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipcode_state_cities_id' => 'nullable|integer',
            'password' => 'required|string|min:8',
            'photo' => 'nullable|image|max:2048',
            'company_name' => 'nullable|string|max:255',
            'gst_id' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $photoRelativePath = null;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->photo->extension();
            $photoPath = $request->file('photo')->move(public_path('images'), $photoFileName);
            $photoRelativePath = 'images/' . $photoFileName;
        }
        $cin_no = 'CIN' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $user = User::create([
            'cin_no' => $cin_no,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number ?? null,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode_state_cities_id' => $request->zipcode_state_cities_id,
            'password' => Hash::make($request->password),
            'photo' => $photoRelativePath,
            'company_name' => $request->company_name,
            'gst_id' => $request->gst_id,
            'status' => 'active',
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}
