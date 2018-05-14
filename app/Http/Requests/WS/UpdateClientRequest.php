<?php

namespace MetodikaTI\Http\Requests\WS;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            /*'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore(decrypt($this->route()->parameter('id')))
            ],
            'password' => 'sometimes|required|min:8|confirmed',*/
            'sexo' => 'required|exists:genders,id',
            'fechaDeNacimiento' => 'required|date|'
        ];
    }
}
