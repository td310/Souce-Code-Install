<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPassRequest extends FormRequest
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
                'max:100',
                'email:rfc,dns',
                'exists:users,email'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Trường :attribute bắt buộc phải nhập.',
            'email.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'email.email' => 'Địa chỉ email không hợp lệ hoặc domain không tồn tại.',
            'email.exists' => ':attribute không tồn tại trong hệ thống.'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email'
        ];
    }
}
