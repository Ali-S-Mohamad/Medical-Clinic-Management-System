<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TimeSlotRequest extends FormRequest
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
            'doctor_id' => 'required|exists:employees,id',  
            'start_time' => 'required|date_format:H:i',      
            'end_time' => 'required|date_format:H:i|after:start_time', 
            'day_of_week' => 'required|integer|between:0,6',  
            'is_available' => 'required|boolean',             
            'slot_duration' => 'required|integer|min:15',   
        ];
    }
}
