<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaneacionAuditoriaEjecucionPlantilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planeacion_auditoria_ejecucion_plantillas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function ejecucion(){
        return $this->belongsTo(PlaneacionAuditoriaEjecucion::class,'ejecucion_id');
    }

    public function documento(){
        return $this->hasOne(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }

    public function seccion(){
        return $this->belongsTo(CatalogoElemento::class,'seccion_id');
    }
}
