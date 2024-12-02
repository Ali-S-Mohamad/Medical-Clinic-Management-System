<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            // 'patient_id' => 'required|exists:patients,id', 
            // 'patient_id' => 'exists:users,id', 
            'doctor_id'  => 'required|exists:employees,id', 
            'doctor_rate'=> 'required|integer|between:0,10',
            'details'    => 'nullable|string|max:200',
        ];
        
    }
}
