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
        $rules = [
            'firstname'     => 'required|string|max:255',
            'lastname'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'gender'     => 'required|in:male,female',
            'phone_number' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'academic_qualifications' => 'nullable|string',
            'previous_experience'     => 'nullable|string',
            'insurance_number'     => ['required', 'regex:/^INS-\d{5}$/'],
            'pdf_cv' => 'file|mimes:pdf|max:2048',
            'image'  => 'image|mimes:jpg,jpeg,png|max:2048',
            'is_doctor' => 'nullable|in:0,1',
            'is_patient' => 'nullable|in:0,1',
            'dob' => 'nullable|date|before_or_equal:today',
        ];

        if ($this->input('is_patient_employee') == '1') {
            $rules['dob'] = 'required|date|before_or_equal:today';
        }
        return $rules;

    }
}
