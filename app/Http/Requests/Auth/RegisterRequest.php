<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:100',
                'unique:users',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'password_confirmation' => [
                'required'
            ],
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
            'email.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'email.email' => 'Trường :attribute không đúng định dạng email.',
            'email.unique' => 'Trường :attribute đã tồn tại trong hệ thống.',

            'password.required' => 'Trường :attribute bắt buộc phải nhập.',
            'password.confirmed' => 'Trường xác nhận :attribute không khớp với mật khẩu đã nhập.',
            'password.min' => 'Trường :attribute phải có ít nhất :min ký tự.',
            'password.mixed' => 'Trường :attribute phải chứa ít nhất một chữ hoa và một chữ thường.',
            'password.numbers' => 'Trường :attribute phải chứa ít nhất một số.',
            'password.symbols' => 'Trường :attribute phải chứa ít nhất một ký tự đặc biệt.',

            'password_confirmation.required' => 'Trường xác nhận :attribute bắt buộc phải nhập.',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'tên',
            'last_name' => 'họ',
            'email' => 'email',
            'password' => 'mật khẩu',
            'password_confirmation' => 'xác nhận mật khẩu',
        ];
    }
}
