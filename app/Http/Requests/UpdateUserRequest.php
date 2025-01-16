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
    $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'email',
        'department_id' => 'exists:departments,id',
        'academic_qualifications' => 'nullable|string|max:500',
        'previous_experience'     => 'nullable|string|max:500',
        'pdf_cv' => 'file|mimes:pdf|max:2048',
        'image'  => 'image|mimes:jpg,jpeg,png|max:2048',
        'dob'    => 'nullable|date|before_or_equal:today',
    ];
    
    if ($this->input('is_patient_employee') == '1') {
        $rules['dob'] = 'required|date|before_or_equal:today';
    }

    return $rules;
}

}
