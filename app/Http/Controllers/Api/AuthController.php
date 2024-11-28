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
use SomarKesen\TelegramGateway\Facades\TelegramGateway;




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
        $data = $request->only('dob','insurance_number');
        $patient = new PatientController();
        $patientUser = $patient->storePatientDetails($user_id, $data);

        // إنشاء رمز تحقق
        $verificationCode = rand(1000, 9999);

        // إرسال رسالة التحقق عبر Telegram Gateway
        $response = TelegramGateway::sendVerificationMessage($request->phone_number, [
            'code' => $verificationCode,
            'ttl' => 300, // مدة صلاحية الرمز 300 ثانية
            'callback_url' => 'http://127.0.0.1:8000/api/verify-callback', // رابط استدعاء بعد التحقق
            // 'callback_url' => route('verify.callback'), // رابط استدعاء بعد التحقق
        ]);


        $token = $user->createToken('token')->plainTextToken;

        // if ($response['status'] === 'success') {
        if ($response) {
            return $this->apiResponse([
                'token' => $token,
                'user' => $patientUser,
                'verification_code' => $verificationCode
            ], 'Registration success and verification message sent', 200);
        } else {
            return $this->apiResponse([
                'token' => $token,
                'user' => $patientUser,
                'error' => $response['message']
            ], 'Registration success but failed to send verification message', 200);
        }
        // return $this->apiResponse([$token, $patientUser], 'Registeration Success', 200);
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
