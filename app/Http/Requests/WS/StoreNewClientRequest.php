<?php

namespace MetodikaTI\Http\Requests\WS;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewClientRequest extends FormRequest
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
            //'email' => 'required|email|unique:users,email',
            //'password' => 'required|min:8|confirmed',
            'imagenDePerfil' => 'sometimes|image',
            'sexo' => 'required|exists:genders,id',
            'fechaDeNacimiento' => 'required|date|'
        ];
    }
}
