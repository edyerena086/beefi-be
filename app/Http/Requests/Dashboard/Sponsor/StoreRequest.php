<?php

namespace MetodikaTI\Http\Requests\Dashboard\Sponsor;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empresa' => 'required',
            'imagen' => 'required|image',
            'categoria*' => 'sometimes|integer|exists:categories,id',
            'compania*' => 'sometimes|integer|exists:companies,id'
        ];
    }
}
