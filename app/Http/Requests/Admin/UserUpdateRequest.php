<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\AuthStatus;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:100',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'status' => [
                'nullable',
                Rule::enum(AuthStatus::class),
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

            'status.in' => 'Trường :attribute không hợp lệ.',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'tên',
            'last_name' => 'họ',
            'address' => 'địa chỉ',
            'email' => 'email',
            'status' => 'trạng thái',
        ];
    }
}
