<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class PlaneacionAuditoriaEjecucion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planeacion_auditoria_ejecuciones';

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
     protected $casts = [
        'fecha_seguimiento' => 'datetime:Y-m-d'
    ];


    public function grupo(){
        return $this->belongsTo(PlaneacionAuditoria::class,'planeacion_auditoria_id');
    }

    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }

    public function asignado(){
        return $this->belongsTo(User::class,'auditor_asignado_id');
    }

    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }

    public function plantillas(){
        return $this->hasMany(PlaneacionAuditoriaEjecucionPlantilla::class,'ejecucion_id');
    }

    public function cedulas(){
        $seccion = CatalogoElemento::whereCodigo('seccion_cedulas_de_trabajo')->first();
        if ($seccion) {
            return $this->hasMany(PlaneacionAuditoriaEjecucionPlantilla::class,'ejecucion_id')->where('seccion_id', '=', $seccion->id);
        }
        return null;
    }

    public function resultados(){
        $seccion = CatalogoElemento::whereCodigo('seccion_resultados_preliminares')->first();
        if ($seccion) {
            return $this->hasMany(PlaneacionAuditoriaEjecucionPlantilla::class,'ejecucion_id')->where('seccion_id', '=', $seccion->id);
        }
        return null;
    }

    public function respuestas(){
        return $this->hasMany(PlaneacionAuditoriaEjecucionListaRespuesta::class,'ejecucion_id')->orderBy('pregunta_id');
    }

    public function cierre(){
        $seccion = CatalogoElemento::whereCodigo('seccion_cierre_auditoria')->first();
        if ($seccion) {
            return $this->hasMany(PlaneacionAuditoriaEjecucionPlantilla::class,'ejecucion_id')->where('seccion_id', '=', $seccion->id);
        }
        return null;
    }

    public function solicitud(){
        return $this->belongsTo(PlaneacionSolicitudExpediente::class,'solicitud_expediente_id');
    }

    public function getNombreMesAttribute(){
        return ucfirst(Carbon::parse("2023-$this->mes-01")->translatedFormat('F'));
    }
}
