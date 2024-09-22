<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $dateString = $this->input('published_at');

        $formattedDate = date('Y-m-d', strtotime($dateString));

        $this->merge([
            'published_at' => $formattedDate,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|max:255',
            'author' => 'sometimes|required|max:255',
            'published_at' => 'sometimes|required|date',
            'is_active' => 'sometimes|boolean'

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'يرجى التأكد من المدخلات',
            'errors' => $validator->errors(),

        ]));
    }
}
