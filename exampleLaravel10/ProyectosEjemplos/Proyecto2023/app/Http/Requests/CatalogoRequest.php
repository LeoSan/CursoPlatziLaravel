<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;
use Illuminate\Http\Request;

class CatalogoRequest extends FormRequest
{
    /**
     * Description: Esto permite que pueda usarse el controlador desde un evento create o update
     *
     * @return type bool  -> true
     */
    public function authorize():bool
    {
        return  true;
    }
    /**
     * Description: Valida al crear un elemento
     *
     * @param type $request
     * @return type array  -> Describe los errores en caso de ser encontrado
     */
    public function validatorElementCreate(Request $request)
    {

        $rules=[
            'nombre' => 'unique:catalogos,nombre|required|max:255',
            'codigo' => 'unique:catalogos,codigo|required|max:100',
            'orden'  => 'required|numeric',
            'catalogo_id'  => 'required|numeric',
        ];
        $msgs=[
            'nombre.unique'    => 'El nombre ingresado ya existe.',
            'nombre.required'  => 'El campo nombre es requerido.',
            'nombre.max'       => 'El campo nombre acepta un máximo de 255 caracteres.',
            'codigo.unique'    => 'El código ingresado ya existe.',
            'codigo.required'  => 'El campo código es requerido.',
            'codigo.max'       => 'El campo código acepta un máximo de 100 caracteres.',
            'orden.required'   => 'El campo orden es requerido.',
            'orden.numeric'    => 'El campo orden debe ser númerico.',
            'catalogo_id.required'    => 'El campo catalogo_id es requerido.',
            'catalogo_id.numeric'    => 'El campo catalogo_id debe ser númerico.',

        ];
        $validator = Validator::make($request->all(), $rules, $msgs );

        if ($validator->fails())
            return $validator->errors();
        return [];
    }
    /**
     * Description: Valida al editar un elemento
     *
     * @param type $request
     * @return type array  -> Describe los errores en caso de ser encontrado
     */
    public function validatorElementEdit(Request $request)
    {

        $rules=[
            'nombre' => 'required|max:255',
            'codigo' => 'required|max:100',
            'orden'  => 'required|numeric',
        ];
        $msgs=[
            'nombre.required'  => 'El campo nombre es requerido.',
            'nombre.max'       => 'El campo nombre acepta un máximo de 255 caracteres.',
            'codigo.required'  => 'El campo código es requerido.',
            'codigo.max'       => 'El campo código acepta un máximo de 100 caracteres.',
            'orden.required'   => 'El campo orden es requerido.',
            'orden.numeric'    => 'El campo orden debe ser númerico.',
        ];
        $validator = Validator::make($request->all(), $rules, $msgs );

        if ($validator->fails())
            return $validator->errors();
        return [];
    }
}
