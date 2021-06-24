<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'public_sector' => 'required',
            'investigator' => 'nullable',
            'judicial_officer_id' => 'nullable',
            'status' => 'required|string',
            'published' => 'required|boolean',
        ];
    }
}
