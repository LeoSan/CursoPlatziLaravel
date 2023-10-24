<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formulario extends Model
{
    use HasFactory,SoftDeletes;
    protected $casts = ['created_at'=>'date'];
    protected $table='formularios';
    protected $guarded=[];

    public function tipoInspeccion(){
        return $this->belongsTo(CatalogoElemento::class,'tipo_inspeccion_id');
    }

    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }

    public function secciones(){
        return $this->hasMany(FormularioSeccion::class,'formulario_id')->orderBy('id');
    }

    public function seccionesConPreguntas(){
        return $this->secciones()->has('preguntas');
    }

    public function seccionesSinPreguntas(){
        return $this->secciones()->whereDoesntHave('preguntas');
    }

    public function preguntas(){
        return $this->hasMany(FormularioSeccionPregunta::class,'formulario_id');
    }
}
