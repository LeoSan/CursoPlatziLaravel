<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    //si qieremos transformar cada uno de los datos de la colecction que se definio en el resourse 
    public $collects = ProductResource::class; 


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
              
                // return parent::toArray($request);

                // Así Podremos anexar nuevos valores  a json 
                return [
                    "data" => $this->collection,
                    "links" => "metadata"
                ];
    }
}
