<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Trường :attribute bắt buộc phải nhập.',
            'email.email' => 'Trường :attribute không đúng định dạng.',
            'email.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'email.exists' => ':attribute không tồn tại trong hệ thống',
            'password.required' => 'Trường :attribute bắt buộc phải nhập.',
        ];
    }
}
