<?php

namespace App\Http\Controllers\Api;

use Attribute;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    use ApiResponse;


    //registering
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
<<<<<<< HEAD
=======
            'phone_number' => $request->phone_number,
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
            'password' => Hash::make($request->password),
            'is_patient' => true
        ]);
        $user_id = $user->id;
        $data = $request->only('dob');
        $patient = new PatientController();
        $patientUser = $patient->storePatientDetails($user_id, $data);

        $token = $user->createToken('token')->plainTextToken;
        return $this->apiResponse([$token, $patientUser] , 'Registeration Success', 200);
    }


    //login
    public function login(LoginRequest $request)
    {

        // Check email exist
        $user = User::where('email', $request->email)->first();


        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        return $this->apiResponse($data, 'Login success', 200);
    }


    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse('user logged out');
    }
}
