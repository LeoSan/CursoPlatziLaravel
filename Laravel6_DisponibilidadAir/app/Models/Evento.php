<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table='eventos';
    protected $guarded=[];
    protected $hidden=['pivot','created_at','updated_at','plataforma_id'];
    protected $dates=['created_at','fecha'];

    public function persona(){
        return $this->belongsToMany(Persona::class,'evento_personas');
    }
    public function eventoPersonas(){
        return $this->hasMany(EventoPersona::class,'evento_id','id');
    }
}
