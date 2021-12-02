<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoRequest
{
    /**
     * Valida el registro de eventos
     * @param Request $request
     * @return array
     */
    public function validarRegistro(Request $request)
    {
        if(!isset($request->eventos)){
            return [
                'Error al crear eventos'
            ];
        }

        $rules = [
            'id'=>'required',
            'fecha'=>'required|date',
            'titulo'=>'required',
            'tipo'=>'required',
            'codigo_estado'=>'required',
            'municipio_alcaldia'=>'required',
            'referencia' => 'required',
            'referencia_id' => 'required'
        ];
        $messages = [
            'id.required'=>'El id del evento es requerido',
            'fecha.required'=>'La fecha es requerida',
            'fecha.date'=>'La fecha no es tipo fecha',
            'titulo.required' => 'El titulo del evento es requerido',
            'tipo.required' => 'El tipo de evento es requerido',
            'codigo_estado.required' => 'El código del estado es requerido',
            'municipio_alcaldia.required' => 'El municipio es requerido',
            'referencia.required' => 'La referencia es requerida',
            'referencia_id.required' => 'El id de la referencia es requerida',
        ];
        foreach ($request->eventos as $key=>$evento){
            if(isset($evento['persona_ids'])){
                $rules['persona_ids']='required|array';
                $messages['persona_ids.required']='El o los ids de las personas son requeridos';
                $messages['persona_ids.array']='Los ids de las personas deben de ser un arreglo';
            }else{
                $rules['persona_ids']='';
            }
            $validator = Validator::make($evento, $rules, $messages);
            if ($validator->fails()) {
                return [
                    $validator->messages()
                ];
            }
        }
        return [];
    }

    /**
     * Valida la consulta de eventos
     * @param Request $request
     * @return array
     */
    public function validarConsulta(Request $request)
    {
        $reglas=[
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date|after_or_equal:fecha_inicio',
        ];
        $mensajes=[
            'fecha_inicio.required'=>'La fecha de inicio es requerida',
            'fecha_inicio.date'=>'La fecha de inicio no es tipo fecha',
            'fecha_fin.required'=>'La fecha final es requerida',
            'fecha_fin.date'=>'La fecha final no es tipo fecha',
            'fecha_fin.after_or_equal' => 'La fecha final debe ser mayor o igual a la fecha inicial'
        ];
        if(isset($request->persona_ids)){
            $reglas['persona_ids']='required|array';
            $mensajes['persona_ids.required']="Los ids de las personas son requeridos";
            $mensajes['persona_ids.array']="Los ids de las personas deben de ser un arreglo";
        }
        $validator = Validator::make($request->all(), $reglas, $mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
    /**
     * Valida la consulta por referencia y referencia id
     * @param Request $request
     * @return array
     */
    public function validarConsultaReferencia(Request $request){
        $reglas=[
            "referencia"=>'required',
            "referencia_id"=>'required'
        ];
        $mensajes=[];
        $validator = Validator::make($request->all(), $reglas, $mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
    /**
     * Valida la consulta de evento
     * @param Request $request
     * @return array
     */
    public function validarConsultaEvento(Request $request){
        $reglas=[
            "id"=>'required',
        ];
        $mensajes=[];
        $validator = Validator::make($request->all(), $reglas, $mensajes);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
}
