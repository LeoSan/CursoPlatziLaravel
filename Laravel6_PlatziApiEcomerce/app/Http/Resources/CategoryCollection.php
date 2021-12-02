<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class CategoryCollection extends ResourceCollection
{
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
