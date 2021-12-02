<?php

namespace App\Http\Requests;


use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaRequest
{
    /**
     * Valida la consulta de disponibilidad
     * @param Request $request
     * @return array
     */
    public function validarConsultaDisponibilidad(Request $request){
        $validator = Validator::make($request->all(),[
            'persona_id'=>'required|int',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after_or_equal:fecha_inicio',
        ],[
            'persona_id.required'=>'El id de las persona es requerido',
            'persona_id.required'=>'El id de las persona tiene que ser un número',
            'fecha_inicio.required'=>'La fecha de inicio es requerida',
            'fecha_inicio.date'=>'La fecha de inicio no es tipo fecha',
            'fecha_fin.required'=>'La fecha final es requerida',
            'fecha_fin.date'=>'La fecha final no es tipo fecha',
            'fecha_fin.after_or_equal' => 'La fecha final debe ser mayor o igual a la fecha inicial'
        ]);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }

    /**
     * Valida la consulta de eventos
     * @param Request $request
     * @return array
     */
    public function validarConsultaPersonas(Request $request){
        $reglas=[
            'fechas'=>'required|array',
            'fechas.*'=>'date',
            'persona_ids'=>'required|array'
        ];
        $mensajes=[
            'fecha.required'=>'La fecha es requerida',
            'fecha.date'=>'La fecha debe ser de tipo fecha',
            'fecha.array'=>'Las fechas deben de ser un arreglo',
            'persona_ids.required'=>'Los ids de las personas son requeridos',
            'persona_ids.array'=>'Los ids de las personas deben ser un arreglo',
        ];
        if(isset($request->codigo_estado)){
            $reglas['codigo_estado']='required|string';
            $mensajes['codigo_estado.required']="El código del estado es requerido";
            $mensajes['codigo_estado.string']="El código del estado debe ser de tipo texto";
        }
        $validator = Validator::make($request->all(),$reglas,$mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
    /**
     * Valida la consulta de eventos por zona y fecha
     * @param Request $request
     * @return array
     */
    public function validarFechaZona(Request $request){
        $reglas=[
            'fecha'=>'required|date',
            'persona_ids'=>'required|array'
        ];
        $mensajes=[
            'fecha.required'=>'La fecha es requerida',
            'fecha.date'=>'La fecha debe ser de tipo fecha',
            'persona_ids.required'=>'Los ids de las personas son requeridos',
            'persona_ids.array'=>'Los ids de las personas deben ser un arreglo',
        ];
        if(isset($request->codigo_estado)){
            $reglas['codigo_estado']='required|string';
            $mensajes['codigo_estado.required']="El código del estado es requerido";
            $mensajes['codigo_estado.string']="El código del estado debe ser de tipo texto";
        }
        $validator = Validator::make($request->all(),$reglas,$mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
    /**
     * Valida la consulta de eventos por zona y fecha
     * @param Request $request
     * @return array
     */
    public function validarPeriodoZonas(Request $request){
        $reglas=[
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date',
            'codigo_estados'=>'array',
            'personas'=>'required|array',
        ];
        $mensajes=[
        ];
        $validator = Validator::make($request->all(),$reglas,$mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
}
