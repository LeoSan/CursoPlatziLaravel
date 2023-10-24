<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domicilio extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='domicilios';
    protected $guarded=[];
    protected $dates=['created_at','updated_at'];
    /**
     * Description : Relaciones con la tabla
    */
    public function entidad(){
        return $this->morphTo('entidad');
    }
    public function departamento(){
        return $this->belongsTo(CatalogoElemento::class,'departamento_id');
    }
    public function municipio(){
        return $this->belongsTo(CatalogoElemento::class,'municipio_id');
    }
}
