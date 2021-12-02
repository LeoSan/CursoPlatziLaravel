<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table='personas';
    protected $guarded=[];
    protected $hidden = ['created_at','updated_at','plataforma_id','pivot'];
    protected $dates = ['created_at'];

    public function eventos(){
        return $this->belongsToMany(Evento::class,'evento_personas');
    }
}
