<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Validator;
use Illuminate\Http\Request;

class RepositoryRequest //extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
      
     
    public function authorize(){
        //Podemos poner condición ara que se cumpla lo ponemos en true 
        return true;
    }
    
    public function validarRegistroJson(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            [
                'url'=>'required'
                ,'description'=>'required'
            ],
            [
                'url.required'=>'Url es obligatoria.'
                ,'description.required'=>'La Descripcion es obligatoria'

            ]
        );

        if ($validator->fails())
            return $validator->errors();

         return [];
    }    
    
    public function validarRegistroWeb(Request $request){
        
        $request->validate(
            [
                'url'=>'required'
                ,'description'=>'required'
            ],
            [
                'url.required'=>'Url es obligatoria.'
                ,'description.required'=>'La Descripcion es obligatoria'

            ]
        );

        return $request;

    } 


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                'url'=>'required'
                ,'description'=>'required'
            ],
            [
                'url.required'=>'Url es obligatoria.'
                ,'description.required'=>'La Descripcion es obligatoria'

            ]
        ];
    }
}
