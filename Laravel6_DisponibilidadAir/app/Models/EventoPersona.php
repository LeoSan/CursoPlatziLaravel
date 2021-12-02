<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoPersona extends Model
{
    use HasFactory;
    protected $fillable=['evento_id','persona_id'];
    protected $guarded=[];

    public function evento(){
        return $this->belongsTo(Evento::class,'evento_id');
    }
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id');
    }
}
