<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoPersonaRequest
{
    /**
     * Valida la asignación de eventos
     * @param Request $request
     * @return array
     */
    public function validarAsignacion(Request $request)
    {
        $rules=[
            'persona_ids'=>'required|array',
            'remplazo'=>'required|boolean'
        ];
        $msgs=[
            'persona_ids.required'=>'Los ids de las personas son requeridos',
            'persona_ids.array'=>'Los ids de las personas deben de ser un arreglo',
            'remplazo.required'=>'El parametro remplazo es requerido',
            'remplazo.boolean'=>'El parametro remplazo debe ser un booleano',
        ];
        if((!isset($request->evento_ids))&&(!isset($request->evento_plataforma_ids)))
            return ['Los ids de los eventos son requeridos'];
        if(isset($request->evento_ids)){
            $rules['evento_ids']='required|array';
            $rules['evento_ids.*']='exists:eventos,id';
            $msgs['evento_ids.required']='Los ids de los eventos asignar son requeridos';
            $msgs['evento_ids.array']='Los ids de los eventos deben de ser un arreglo';
            $msgs['evento_ids.*.exists']='El evento no existe en la base de datos';
        }
        else if(isset($request->evento_plataforma_ids)){
            $rules['evento_plataforma_ids']='required|array';
            $rules['evento_plataforma_ids.*']='exists:eventos,evento_id';
            $msgs['evento_plataforma_ids.required']='Los ids de los eventos asignar son requeridos';
            $msgs['evento_plataforma_ids.array']='Los ids de los eventos deben de ser un arreglo';
            $msgs['evento_plataforma_ids.*.exists']='El id del evento no existe en la base de datos';
        }
        $validator = Validator::make($request->all(),$rules,$msgs);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }

    /**
     * Valida la desasignación de eventos
     * @param Request $request
     * @return array
     */
    public function validarDesasignacion(Request $request)
    {
        $rules=[
            'persona_id'=>'required|exists:evento_personas,persona_id'
        ];
        $msgs=[
            'persona_id.required' => 'El id de la persona es requerido',
            'persona_id.exists' => 'La persona no tiene asignado ningún evento',
        ];
        if((!$request->evento_ids)&&(!$request->evento_plataforma_ids))
            return ['Los ids de los eventos son requeridos'];
        if($request->evento_ids){
            $rules['evento_ids']='required|array';
            $msgs['evento_ids.required']='Los ids de los eventos asignar son requeridos';
            $msgs['evento_ids.array']='Los ids de los eventos deben de ser un arreglo';
        }
        if($request->evento_plataforma_ids){
            $rules['evento_plataforma_ids']='required|array';
            $msgs['evento_plataforma_ids.required']='Los ids de los eventos asignar son requeridos';
            $msgs['evento_plataforma_ids.array']='Los ids de los eventos deben de ser un arreglo';
        }
        $validator = Validator::make($request->all(),$rules,$msgs);
        if ($validator->fails()) {
            return [
                $validator->messages()
            ];
        }
        return [];
    }
}
