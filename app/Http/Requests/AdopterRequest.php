<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdopterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'adopter_email' => 'email:unique:adopters,adopter_email',
            //'adopter_phone' => 'unique:adopters,adopter_phone',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'adopter_email.unique'=>"Opiekun o podanym adresie email już istnieje!",
            //'adopter_phone.unique'=>"Opiekun o podanym numerze telefonu już istnieje!",
        ];
    }
}
