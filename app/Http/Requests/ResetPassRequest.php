<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
            'password.required' => 'Trường :attribute bắt buộc phải nhập.',
            'password.confirmed' => 'Trường xác nhận :attribute không khớp với mật khẩu đã nhập.',
            'password.min' => 'Trường :attribute phải có ít nhất :min ký tự.',
            'password.mixed' => 'Trường :attribute phải chứa ít nhất một chữ hoa và một chữ thường.',
            'password.numbers' => 'Trường :attribute phải chứa ít nhất một số.',
            'password.symbols' => 'Trường :attribute phải chứa ít nhất một ký tự đặc biệt.',

            'password_confirmation.required' => 'Trường xác nhận :attribute bắt buộc phải nhập.'
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'mật khẩu',
            'password_confirmation' => 'xác nhận mật khẩu'
        ];
    }
}
