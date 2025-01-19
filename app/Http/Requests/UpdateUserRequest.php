<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            // Basic User Information
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required',
            'email',
            Rule::unique('users')->ignore($this->route('user')),
            'gender' => 'required|in:male,female',

            // Password (optional during update)
            'password' => 'min:8|string',
            'confirm_password' => 'min:8|string',

            // Phone Number
            'phone_number' => 'required',
            'string',
            'max:20',
            Rule::unique('users')->ignore($this->route('user')),

            // Department
            'department_id' => 'required|exists:departments,id',

            // Languages
            'languages_ids' => 'nullable|array',
            'languages_ids.*' => 'exists:languages,id',

            // Profile Image
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // CV
            'pdf_cv' => 'nullable|file|mimes:pdf|max:2048',

            // Academic Qualifications and Experience
            'qualifications' => 'nullable|string|max:500',
            'experience' => 'nullable|string|max:500',

            // Doctor Flag
            'is_doctor' => 'nullable|in:0,1',

            // Patient Information
            'is_patient_employee' => 'nullable|in:0,1',
            'insurance_number' => 'nullable|string|max:50|required_if:is_patient_employee,1',
            'dob' => 'nullable|date|before_or_equal:today|required_if:is_patient_employee,1',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Basic User Information
            'firstname.required' => 'The first name is required.',
            'firstname.string' => 'The first name must be a valid string.',
            'firstname.max' => 'The first name cannot exceed 255 characters.',
            'lastname.required' => 'The last name is required.',
            'lastname.string' => 'The last name must be a valid string.',
            'lastname.max' => 'The last name cannot exceed 255 characters.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'The email address has already been taken.',
            'gender.required' => 'The gender is required.',
            'gender.in' => 'The gender must be either male or female.',

            // Password
            'password.min' => 'The password must be at least 8 characters.',
            'password.string' => 'The password must be a valid string.',
            'confirm_password.min' => 'The confirmation password must be at least 8 characters.',
            'confirm_password.string' => 'The confirmation password must be a valid string.',

            // Phone Number
            'phone_number.required' => 'The phone number is required.',
            'phone_number.string' => 'The phone number must be a valid string.',
            'phone_number.max' => 'The phone number cannot exceed 20 characters.',
            'phone_number.unique' => 'The phone number has already been taken.',

            // Department
            'department_id.required' => 'The department is required.',
            'department_id.exists' => 'The selected department does not exist.',

            // Languages
            'languages_ids.array' => 'The languages must be a valid array.',
            'languages_ids.*.exists' => 'One or more selected languages are invalid.',

            // Profile Image
            'profile_image.image' => 'The profile image must be a valid image file.',
            'profile_image.mimes' => 'The profile image must be a file of type: jpg, jpeg, png.',
            'profile_image.max' => 'The profile image size cannot exceed 2 MB.',

            // CV
            'pdf_cv.file' => 'The CV must be a valid file.',
            'pdf_cv.mimes' => 'The CV must be a PDF file.',
            'pdf_cv.max' => 'The CV size cannot exceed 2 MB.',

            // Academic Qualifications and Experience
            'qualifications.string' => 'The qualifications must be a valid string.',
            'qualifications.max' => 'The qualifications cannot exceed 500 characters.',
            'experience.string' => 'The experience must be a valid string.',
            'experience.max' => 'The experience cannot exceed 500 characters.',

            // Doctor Flag
            'is_doctor.in' => 'The doctor flag must be either 0 or 1.',

            // Patient Information
            'is_patient_employee.in' => 'The patient employee flag must be either 0 or 1.',
            'insurance_number.required_if' => 'The insurance number is required when the patient is an employee.',
            'insurance_number.string' => 'The insurance number must be a valid string.',
            'insurance_number.max' => 'The insurance number cannot exceed 50 characters.',
            'dob.required_if' => 'The date of birth is required when the patient is an employee.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'The date of birth must be before or equal to today.',
        ];
    }
}
