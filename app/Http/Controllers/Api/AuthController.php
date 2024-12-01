<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Api\PatientController;




class AuthController extends Controller
{
    use ApiResponse;


    //registering
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_patient' => true
        ]);

        $user_id = $user->id;
        $user->assignRole('patient');

        // Calling PatientController to store Patient Details
        $patientController = new PatientController();
        $patient = $patientController->storePatientDetails($user_id, $request);

        $token = $user->createToken('token')->plainTextToken;

        return $this->apiResponse([$token, $user, $patient], 'Registeration Success', 200);
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
