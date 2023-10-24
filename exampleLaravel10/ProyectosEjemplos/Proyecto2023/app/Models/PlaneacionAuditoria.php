<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaneacionAuditoria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planeacion_auditorias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'planeacion_id',
        'departamento_id',
        'municipio_id',
        'tipo_inspeccion_id',
        'actividad_economica_id',
        'cafta',
        'creador_id',
        'auditor_responsable_id',
        'estatus_id',
        'region_id',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function planeacion(){
        return $this->belongsTo(Planeacion::class,'planeacion_id');
    }

    public function meses(){
        return $this->hasMany(PlaneacionAuditoriaMes::class,'planeacion_auditoria_id')->orderBy('mes');
    }

    public function ejecuciones(){
        return $this->hasMany(PlaneacionAuditoriaEjecucion::class,'planeacion_auditoria_id')->orderBy('mes');
    }

    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }

    public function departamento(){
        return $this->belongsTo(CatalogoElemento::class,'departamento_id');
    }

    public function inspeccion(){
        return $this->belongsTo(CatalogoElemento::class,'tipo_inspeccion_id');
    }

    public function actividadEconomica(){
        return $this->belongsTo(CatalogoElemento::class,'actividad_economica_id');
    }

    public function auditor(){
        return $this->belongsTo(User::class,'auditor_responsable_id');
    }

    public function municipio(){
        return $this->belongsTo(CatalogoElemento::class,'municipio_id');
    }

    public function region(){
        return $this->belongsTo(CatalogoElemento::class,'region_id');
    }
    public function planeacion_auditoria_mes( int $mes,int $planeacion_auditoria_id){
        $grupo_auditorias = PlaneacionAuditoriaMes::where('mes',$mes)->where('planeacion_auditoria_id',$planeacion_auditoria_id)->first();
        return $grupo_auditorias;
    }
    public function planeacion_auditoria_ejecuciones( int $mes,int $planeacion_auditoria_id){
        return PlaneacionAuditoriaEjecucion::where('mes',$mes)->where('planeacion_auditoria_id',$planeacion_auditoria_id)->orderBy('id')->get();

    }
    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }
}
