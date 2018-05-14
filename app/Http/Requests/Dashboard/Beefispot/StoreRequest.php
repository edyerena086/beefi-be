<?php

namespace MetodikaTI\Http\Requests\Dashboard\Beefispot;

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
            'titulo'  => 'required',
            'descripcion' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric'
        ];
    }
}
