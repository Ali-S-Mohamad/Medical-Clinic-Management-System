<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicInfoRequest extends FormRequest
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
           'profile_image'  => 'image|mimes:jpg,jpeg,png|max:2048' ,
           'email' => 'required|email',
           'phone'   => 'required|string', 
           'established_at' => 'required|date',
           'address' => 'required|string',
           'about'   => 'required|string',
           
        ];
    }
}
