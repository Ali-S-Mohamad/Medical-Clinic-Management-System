<?php

namespace App\Http\Requests;

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
        return [
            'name'  => 'required|string|max:255',
            'email' => 'email',
            'department_id' => 'required|exists:departments,id',
            'is_patient'    =>'boolean',
            'academic_qualifications'=> 'nullable|string|max:500',
            'previous_experience'    => 'nullable|string|max:500',
            'pdf_cv' => 'file|mimes:pdf|max:2048',
            'image'  => 'image|mimes:jpg,jpeg,png|max:2048' 
        ];
    }
}
