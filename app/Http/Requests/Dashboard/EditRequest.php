<?php

namespace MetodikaTI\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipoDePromocion' => 'required|between:1,3',
            'tituloDePromocion' => 'required|min:3',
            'descripcion' => 'required',
            'fechaDeTermino' => 'required|date|after:yesterday',
            'empresa' => 'required',
            'url' => 'sometimes|url',
            'archivo' => 'sometimes|image'
        ];
    }
}
