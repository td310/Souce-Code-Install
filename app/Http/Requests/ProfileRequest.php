<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Trường :attribute bắt buộc phải nhập.',
            'first_name.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'last_name.required' => 'Trường :attribute bắt buộc phải nhập.',
            'last_name.max' => 'Trường :attribute không được vượt quá :max ký tự.',
            
            'address.max' => 'Trường :attribute không được vượt quá :max ký tự.'
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'tên',
            'last_name' => 'họ',
            'address' => 'địa chỉ',
        ];
    }
}
