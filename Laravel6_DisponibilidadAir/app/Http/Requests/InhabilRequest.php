<?php

namespace App\Http\Requests;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\is_settled;

class InhabilRequest
{
    /**
     * Valida el registro de días inhabiles
     * @param Request $request
     * @return array
     */
    public function validarRegistro(Request $request){

       $rules['persona_id'] = 'required_if:tipo_inhabil,==,persona|integer';
       $messages['persona_id.required_if']='El id de la persona es requerida.';

       $rules['tipo_inhabil'] = 'required|string';
       $messages['tipo_inhabil.required']='El tipo inhabil es requerida.';

        if($request->tipo_inhabil != "persona" && isset($request->persona_id)){
            return ['mensaje' => ['El campo persona_id no es requerido.'] ];
        }

        if(isset($request->fechas)){
            $rules['fechas']='required|array';
            $rules['fechas.*']='date';
            $messages['fechas.required']='Las fechas son requeridas';
            $messages['fechas.array']='Las fechas deben de ser un arreglo';
            $messages['fechas.*.date']='La fecha no es tipo fecha';
        }
        else if(isset($request->fecha_inicio)){
            $rules['fecha_inicio']='required|date';
            $rules['fecha_fin']='required|date|after_or_equal:fecha_inicio';
            $messages['fecha_inicio.required']='La fecha de inicio es requerida';
            $messages['fecha_inicio.date']='La fecha de inicio no es tipo fecha';
            $messages['fecha_fin.required']='La fecha final es requerida';
            $messages['fecha_fin.date']='La fecha final no es tipo fecha';
            $messages['fecha_fin.after_or_equal']='La fecha final debe ser mayor o igual a la fecha inicial';
        }

        if(isset($request->inhabil_id)){
            $rules['inhabil_id'] = 'required|integer';
            $messages['inhabil_id.required']='El id de día inhabil es requerido para eliminar una fecha';
            $messages['inhabil_id.integer']='El id de día inhabil debe ser un valor entero';
        }


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }

    /**
     * Validar Datos Consulta Dias Inhabiles por personas 
     */
    public function validarConsultaPersona(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'persona_ids' => 'required|array',
            ],
            [
                'persona_ids.required' => 'Favor de indicar la Id o Ids del usuario.',
                'persona_ids.array' => 'Persona ids deben de ser un arreglo.',
            ]
        );

        if ($validator->fails())
            return $validator->errors();

         return [];
    }   
}
