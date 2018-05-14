<?php

namespace MetodikaTI\Http\Requests\Dashboard\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'nombre' => 'required',
            'correoElectronico' => 'required|email',
            'password' => 'sometimes|min:8|confirmed',
            'logo' => 'sometimes|image',
            'logoBlanco' => 'sometimes|image'
        ];
    }
}
