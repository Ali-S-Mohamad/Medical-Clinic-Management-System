<?php

namespace App\Http\Controllers\Api;

use Attribute;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     use ApiResponse;


    //registering
     public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250|email',
            'password' => 'required|string|min:8|confirmed'

        ]);

        if($validate->fails()){
         return $this->errorResponse('Validation Error!', 403);

        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_patient' => false
        ]);

         $token=$user->createToken('token')->plainTextToken;
         return $this->apiResponse($token,'Registeration Success',200);
    }


    //login
     public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
             return $this->errorResponse('Validation Error!', 403);
        }

        // Check email exist
        $user = User::where('email', $request->email)->first();

        // Check password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        return $this->apiResponse($data,'Login success', 200);
    }


    //logout
      public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
         return $this->SuccessResponse('user logged out');

    }


}