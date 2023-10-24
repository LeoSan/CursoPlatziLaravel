<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioSeccionPregunta extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='formulario_seccion_preguntas';
    protected $casts=['created_at'=>'date'];
    protected $guarded=[];

    public function seccion(){
        return $this->belongsTo(FormularioSeccion::class,'seccion_id');
    }
    public function formulario(){
        return $this->belongsTo(Formulario::class,'formulario_id');
    }
}
