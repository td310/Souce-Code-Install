<?php

namespace App\Http\Requests\User\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'publish_date' => ['required', 'date', 'after_or_equal:today'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Trường :attribute bắt buộc phải nhập.',
            'title.max' => 'Trường :attribute không được vượt quá :max ký tự.',

            'description.max'       => 'Trường :attribute không được vượt quá :max ký tự.',

            'content.required' => 'Trường :attribute bắt buộc phải nhập.',

            'publish_date.required' => 'Trường :attribute bắt buộc phải nhập.',
            'publish_date.date'     => 'Trường :attribute phải là định dạng ngày giờ hợp lệ.',
            'publish_date.after_or_equal' => 'Trường :attribute phải là ngày hôm nay hoặc sau đó.',

            'file.file' => 'Trường :attribute phải là một tệp.',
            'file.mimes' => 'Trường :attribute phải là một tệp có định dạng: :values.',
            'file.max' => 'Trường :attribute không được vượt quá :max kilobytes.',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'tiêu đề',
            'description'  => 'mô tả ngắn',
            'content' => 'nội dung bài viết',
            'publish_date' => 'ngày xuất bản',
            'file' => 'hình ảnh',
        ];
    }
}

