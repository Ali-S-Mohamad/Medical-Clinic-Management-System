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
            'start_time' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/'
            ],
            'end_time' => [
                'required',
                'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/',
                'after:start_time'
            ],
            'day_of_week' => 'required|integer|between:0,6',
            'is_available' => 'required|boolean',
            'slot_duration' => 'required|integer|min:15',
        ];
    }
}
