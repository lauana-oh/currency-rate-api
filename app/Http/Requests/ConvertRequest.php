<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.from' => 'required|string',
            '*.to' => 'required|string',
            '*.value' => 'required|numeric',
            '*.date' => 'date_format:Y-m-d',
        ];
    }
}
