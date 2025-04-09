<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaUploadRequest extends FormRequest
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
            'files' => 'required|array|min:1|max:5', // Max 5 files per request
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240', // Max size 10MB
        ];
    }

    public function messages()
    {
        return [
            'files.required' => 'You must upload at least one file.',
            'files.max' => 'You can upload a maximum of 5 files at a time.',
            'files.*.mimes' => 'Invalid file type. Only images and videos are allowed.',
            'files.*.max' => 'Each file must be less than 10MB.',
        ];
    }
}
