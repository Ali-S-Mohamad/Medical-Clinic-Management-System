<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyAccountRequest;
use App\Http\Controllers\Api\PatientController;
use SomarKesen\TelegramGateway\Facades\TelegramGateway;



class AuthController extends Controller
{
    use ApiResponse;


    //register a new patient
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'is_verified' => false,
        ]);
        saveImage('Users images', $request, $user);
        $user_id = $user->id;
        $user->assignRole('patient');

        // Calling PatientController to store Patient Details
        $patientController = new PatientController();
        $patient = $patientController->storePatientDetails($user_id, $request);

        // Creating verification code
        $verificationCode = rand(100000, 999999);

        // Sending verification code to the user's phone number
        try {
            $response = TelegramGateway::sendVerificationMessage("+963996522488", [
                'code' => $verificationCode,
                'ttl' => 300,
            ]);

            if ($response['ok'] === false) {
                return $this->apiResponse(null, 'Failed to send verification code.', 500);
            }

            // Storing the verification code in users table
            $user->verification_code = $verificationCode;
            $user->save();

        } catch (\Exception $e) {
            return $this->errorResponse('Error sending verification code: ' . $e->getMessage());
        }

        return $this->apiResponse($user, 'Registration successful. Please verify your account.', 200);

    }

    /**
     * Function to verify the user account
     * @param \App\Http\Requests\VerifyAccountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyAccount(VerifyAccountRequest $request)
    {
        // Check email exist
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return $this->apiResponse(null, 'User not found.', 404);
        }

        if ($user->verification_code !==  $request->verification_code) {
            return $this->apiResponse(null, 'Invalid verification code.', 400);
        }

        // Success verification
        $user->is_verified = true;
        $user->verification_code = null; // remove code after verification
        $user->save();

        // Create auth token
        $token = $user->createToken('token')->plainTextToken;

        return $this->apiResponse(['token' => $token], 'Account verified successfully.', 200);
    }



    /**
     * Function to login user
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // Check email exist
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        if (!$user->is_verified) {
            return $this->apiResponse(null, 'Account not verified. Please verify your account.', 403);
        }

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        return $this->apiResponse($data, 'Login success', 200);
    }


    /**
     * Function to logout user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse('user logged out');
    }

    /**
     * Function to handle logging in the employee as a patient
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginDoctorAsPatient(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->hasRole('doctor')) {
            $user->update([
                'is_patient' => 1
            ]);
        }

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user_id = $user->id;
        $user->assignRole('patient');

        // Calling PatientController to store Patient Details
        $patientController = new PatientController();
        $patient = $patientController->storePatientDetails($user_id, $request);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        $data['details'] = $patient;

        return $this->apiResponse($data, 'Login success', 200);
    }
}
