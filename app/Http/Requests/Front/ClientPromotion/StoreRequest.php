<?php

namespace MetodikaTI\Http\Requests\Front\ClientPromotion;

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
            'icono' => 'required|image',
            'fechaDeExpiracion' => 'required|date|after:today',
            'textoDePromocion' => 'required',
            'numeroDeCupones' => 'required|integer',
            'genero' => 'required|between:1,3',
            'numeroDeMesas' => 'sometimes|integer',
            'url' => 'required|url',
            'bwallet' => 'required|between:1,2'
        ];
    }

    public function messages()
    {
        return [
            'fechaDeExpiracion.after' => 'El campo fecha de expiracion debe ser una fecha posterior a hoy.',
            'genero.between' => 'El campo genero no existe.'
        ];
    }
}
