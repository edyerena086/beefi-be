<?php

namespace MetodikaTI\Http\Requests\PushNotification;

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
            'titulo' => 'required',
            'mensaje' => 'required',
            'recursoWeb' => 'required|url'
            //'genero' => 'required|integer|between:1,2'
        ];
    }
}
