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
            'email' => 'required','email',Rule::unique('users')->ignore($this->route('user')) ,
            'gender' => 'required|in:male,female',

            // Password (optional during update)
            'password' => 'min:8|string',
            'confirm_password' => 'min:8|string',

            // Phone Number
            'phone_number' => 'required','string','max:20',Rule::unique('users')->ignore($this->route('user')),

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
        // Firstname and Lastname
        'firstname.required' => 'الاسم الأول مطلوب.',
        'firstname.string' => 'الاسم الأول يجب أن يكون نصاً.',
        'firstname.max' => 'الاسم الأول يجب أن لا يتجاوز 255 حرفاً.',
        'lastname.required' => 'اسم العائلة مطلوب.',
        'lastname.string' => 'اسم العائلة يجب أن يكون نصاً.',
        'lastname.max' => 'اسم العائلة يجب أن لا يتجاوز 255 حرفاً.',

        // Email
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

        // Gender
        'gender.required' => 'الجنس مطلوب.',
        'gender.string' => 'الجنس يجب أن يكون نصاً.',

        // Password
        'password.string' => 'كلمة المرور يجب أن تكون نصاً.',
        'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف.',
        'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

        // Phone
        'phone.required' => 'رقم الهاتف مطلوب.',
        'phone.string' => 'رقم الهاتف يجب أن يكون نصاً.',
        'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 20 حرفاً.',
        'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',

        // Department
        'department_id.required' => 'القسم مطلوب.',
        'department_id.exists' => 'القسم المحدد غير موجود.',

        // Languages
        'languages_ids.array' => 'اللغات يجب أن تكون قائمة.',
        'languages_ids.*.exists' => 'اللغة المحددة غير موجودة.',

        // Profile Image
        'profile_image.image' => 'الصورة الشخصية يجب أن تكون ملف صورة.',
        'profile_image.mimes' => 'الصورة الشخصية يجب أن تكون بصيغة jpg, jpeg, أو png.',
        'profile_image.max' => 'حجم الصورة الشخصية لا يجب أن يتجاوز 2 ميجابايت.',

        // CV
        'pdf_cv.file' => 'ملف السيرة الذاتية يجب أن يكون ملفاً.',
        'pdf_cv.mimes' => 'السيرة الذاتية يجب أن تكون بصيغة PDF.',
        'pdf_cv.max' => 'حجم ملف السيرة الذاتية يجب أن لا يتجاوز 2 ميجابايت.',

        // Academic Qualifications and Experience
        'qualifications.string' => 'المؤهلات الأكاديمية يجب أن تكون نصاً.',
        'qualifications.max' => 'المؤهلات الأكاديمية لا يجب أن تتجاوز 500 حرف.',
        'experience.string' => 'الخبرة العملية يجب أن تكون نصاً.',
        'experience.max' => 'الخبرة العملية لا يجب أن تتجاوز 500 حرف.',

        // Doctor Flag
        'is_doctor.in' => 'قيمة "هل هو طبيب" يجب أن تكون إما 0 أو 1.',

        // Patient Fields
        'is_patient_employee.in' => 'قيمة "هل هو مريض وموظف" يجب أن تكون إما 0 أو 1.',
        'insurance_number.required_if' => 'رقم التأمين مطلوب إذا كان الموظف مريضاً.',
        'insurance_number.string' => 'رقم التأمين يجب أن يكون نصاً.',
        'insurance_number.max' => 'رقم التأمين لا يجب أن يتجاوز 50 حرفاً.',
        'dob.required_if' => 'تاريخ الميلاد مطلوب إذا كان الموظف مريضاً.',
        'dob.date' => 'تاريخ الميلاد يجب أن يكون تاريخاً صالحاً.',
        'dob.before_or_equal' => 'تاريخ الميلاد يجب أن يكون قبل أو يساوي اليوم.',
    ];
}




    // public function rules(): array
    // {
    //     return [
    //         'firstname'  => 'required|string|max:255',
    //         'lastname'  => 'required|string|max:255',
    //         'email' => 'email',
    //         'password' => 'required|string',
    //         'confirm_password' => 'required|string',
    //         'gender' => 'nullable|string|max:500',
    //         'department_id' => 'exists:departments,id',
    //         'is_doctor' => 'nullable|in:0,1',
    //         'is_patient' => 'nullable|in:0,1',
    //         'academic_qualifications' => 'nullable|string|max:500',
    //         'previous_experience'    => 'nullable|string|max:500',
    //         'pdf_cv' => 'file|mimes:pdf|max:2048',
    //         'image'  => 'image|mimes:jpg,jpeg,png|max:2048',
    //         // 'dob' => 'nullable|date|before_or_equal:today' ,
    //         'is_patient_employee' => 'nullable|in:0,1'
    //     ];
    //     if ($this->input('is_patient_employee') == '1') {
    //         $rules['dob'] = 'required|date|before_or_equal:today';
    //     }

    //     return $rules;
    // }




}
