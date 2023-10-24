<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaneacionAuditoriaEjecucionListaRespuesta extends Model
{
    use HasFactory;
    protected $table='planeacion_auditoria_ejecucion_lista_respuestas';
    protected $guarded=[];
    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    public function ejecucion(){
        return $this->belongsTo(PlaneacionAuditoriaEjecucion::class,'ejecucion_id');
    }
    public function pregunta(){
        return $this->belongsTo(FormularioSeccionPregunta::class,'pregunta_id');
    }
}
