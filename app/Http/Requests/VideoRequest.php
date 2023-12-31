<?php

namespace App\Http\Requests;

class VideoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|max:255',
            'description' => 'nullable|max:5000',
            'file'       => 'nullable|file',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     * Custom validation message
     */
    public function messages(): array
    {
        return [
            'title.required'  => 'Please give video title',
            'title.max'       => 'Please give video title maximum of 255 characters',
            'description.max' => 'Please give video description maximum of 5000 characters',
            'file.file'     => 'Please give a valid video file',
            'file.max'       => 'Video file max 20MB is allowed',
        ];
    }
}
