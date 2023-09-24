<?php

namespace App\Http\Requests;

class BookRequest extends FormRequest
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
            'title.required'  => 'Please give book title',
            'title.max'       => 'Please give book title maximum of 255 characters',
            'description.max' => 'Please give book description maximum of 5000 characters',
            'file.file'     => 'Please give a valid book file',
            'file.max'       => 'Book file max 20MB is allowed',
        ];
    }
}
