<?php

namespace App\Domain\Excel\Requests;

use App\Domain\Excel\Enums\FileTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExcelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                Rule::file()->max(2048),
                'mimes:xlsx,xls',
            ],
            'type' => [
                'required',
                Rule::enum(FileTypes::class),
            ]
        ];
    }
}
