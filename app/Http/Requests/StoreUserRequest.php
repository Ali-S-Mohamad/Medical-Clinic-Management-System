<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname'     => 'required|string|max:255',
            'lastname'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'gender'     => 'nullable|string|max:255',
            'password' => 'required|string',
            'confirm_password' => 'required|string',
            'department_id' => 'exists:departments,id',
            'academic_qualifications' => 'nullable|string',
            'previous_experience'     => 'nullable|string',
            'pdf_cv' => 'file|mimes:pdf|max:2048',
            'image'  => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}
