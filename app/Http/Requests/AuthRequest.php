<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ]
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Trường :attribute bắt buộc phải nhập.',
            'first_name.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'last_name.required' => 'Trường :attribute bắt buộc phải nhập.',
            'last_name.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'email.required' => 'Trường :attribute bắt buộc phải nhập.',
            'email.email' => 'Trường :attribute không đúng định dạng email.',
            'email.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'email.unique' => 'Trường :attribute đã tồn tại trong hệ thống.',
            'email.regex' => 'Trường :attribute phải là địa chỉ email của Gmail.',

            'password.required' => 'Trường :attribute bắt buộc phải nhập.',
            'password.min' => 'Trường :attribute phải có ít nhất :min ký tự.',
            'password.regex' => 'Trường :attribute phải chứa ít nhất một ký tự thường, một ký tự hoa, một số, và một ký tự đặc biệt.'
        ];
    }
}
