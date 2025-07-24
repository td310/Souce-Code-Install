<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Trường :attribute bắt buộc phải nhập.',
            'content.string' => 'Trường :attribute phải là một chuỗi ký tự.',
        ];
    }

    public function attributes()
    {
        return [
            'content' => 'nội dung bình luận',
        ];
    }
}
