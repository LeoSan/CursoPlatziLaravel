<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoInfraccion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='tipo_infracciones';
    protected $guarded=[];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function sanciones(){
        return $this->hasMany(Sancion::class,'tipo_id');
    }
}
