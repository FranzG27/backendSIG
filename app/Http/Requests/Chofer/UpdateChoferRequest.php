<?php

namespace App\Http\Requests\Chofer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChoferRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'ci'=>['bail','required','min:1', 'max:250'],
            'fecha_nacimiento'=>['bail','required','date'],
            'sexo'=>['bail','required','max:1'],
            'telefono'=>['bail','required','numeric', 'max:999999999'],
            'categoria_licencia'=>['bail','required','min:1', 'max:250'],
            'foto'=>['bail','file', 'max:10240','mimes:jpg,bmp,png,jpeg'],
            'user_id'=>['bail','required','exists:users,id'],

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'ci'=>'',
            'fecha_nacimiento'=>'',
            'sexo'=>'',
            'telefono'=>'',
            'categoria_licencia'=>'',
            'foto'=>'',
            'user_id'=>'',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
