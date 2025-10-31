<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:225'],
            'prix' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'integer'],
        ];
        
        if ($this->method() == "POST") {
            $rules += [
                'image' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            ];
        }
        if ($this->method() == "PUT") {
            $rules += [
                'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            ];
        }
        return $rules;
    }
}
