<?php

namespace App\Http\Requests\Bus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusRequest extends FormRequest
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
            'placa'=>['bail','required','min:1', 'max:250'],
            'modelo'=>['bail','required','min:1', 'max:250'],
            'cantidad_asientos'=>['bail','required','numeric', 'max:999999999'],
            'fecha_asignacion'=>['bail','required','date'],
            'fecha_baja'=>['bail','required','date'],
            'numero_interno'=>['bail','required','numeric', 'max:999999999'],
            'esta_en_recorrido'=>['bail','required','max:1'],
            'user_id'=>['bail','required','exists:users,id'],
            'bus_route_id'=>['bail','required','exists:bus_routes,id'],

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
            'placa'=>'',
            'modelo'=>'',
            'cantidad_asientos'=>'',
            'fecha_asignacion'=>'',
            'fecha_baja'=>'',
            'numero_interno'=>'',
            'esta_en_recorrido'=>'',
            'user_id'=>'',
            'bus_route_id'=>'',

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
