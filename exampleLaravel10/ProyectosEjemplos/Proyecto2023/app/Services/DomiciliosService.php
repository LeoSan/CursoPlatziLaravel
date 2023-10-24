<?php

namespace App\Services;

use Illuminate\Http\Request;

class DomiciliosService
{
    public function guardarDomicilio(Request $request,$entidad){
        \App\Models\Domicilio::updateOrCreate([
            'entidad_id'=>$request->entidad_id??$entidad->id,
            'entidad_type'=>$request->entidad??$entidad->getMorphClass(),
        ],
        [
            'entidad_id'=>$request->entidad_id??$entidad->id,
            'entidad_type'=>$request->entidad??$entidad->getMorphClass(),
            'departamento_id'=>$request->departamento_id,
            'municipio_id'=>$request->municipio_id,
            'ciudad'=>$request->ciudad,
            'calle'=>$request->calle,
            'num_exterior'=>$request->num_exterior,
            'num_interior'=>@$request->num_interior,
            'codigo_postal'=>@$request->codigo_postal
        ]);
    }
}
