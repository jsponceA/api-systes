<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArchivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "archivo" => ["required","file","mimes:xlsx,xls","max:20000"],
        ];
    }

    public function attributes()
    {
        return [
            "archivo" => "excel"
        ];
    }
}
