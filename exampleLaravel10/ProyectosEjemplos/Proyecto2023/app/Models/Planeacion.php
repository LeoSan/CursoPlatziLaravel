<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planeacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planeaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'anio',
        'objetivo',
        'alcance',
        'criterio',
        'recursos',
        'estatus_id',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }
    public function auditorias(){
        return $this->hasMany(PlaneacionAuditoria::class,'planeacion_id');
    }
    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }

    public function ejecuciones()
    {
        return $this->hasManyThrough(
            PlaneacionAuditoriaEjecucion::class, // Modelo de destino
            PlaneacionAuditoria::class,    // Modelo intermedio
            'planeacion_id', // Clave foránea en el modelo intermedio
            'planeacion_auditoria_id',      // Clave foránea en el modelo de destino
            'id',            // Clave primaria en el modelo origen
            'id'             // Clave primaria en el modelo intermedio
        );
    }
}
