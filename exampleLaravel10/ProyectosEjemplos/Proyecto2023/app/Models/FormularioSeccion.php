<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioSeccion extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='formulario_secciones';
    protected $casts=['created_at'=>'date'];
    protected $guarded=[];

    public function formulario(){
        return $this->belongsTo(Formulario::class,'formulario_id');
    }

    public function preguntas(){
        return $this->hasMany(FormularioSeccionPregunta::class,'seccion_id')->orderBy('id');
    }
}
