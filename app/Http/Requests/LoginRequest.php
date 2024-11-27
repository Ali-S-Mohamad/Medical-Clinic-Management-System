<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
<<<<<<< HEAD
    public function authorize(): bool
=======
    public function authorize()
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
<<<<<<< HEAD
    public function rules(): array
=======
    public function rules()
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 80eabe856da1f5424eab8d38476e0782d1eb464c
