<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sancion extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='sanciones';
    protected $guarded=[];

    public function caso(){
        return $this->belongsTo(Caso::class,'caso_id');
    }
    public function tipo(){
        return $this->belongsTo(TipoInfraccion::class,'tipo_id');
    }
}
