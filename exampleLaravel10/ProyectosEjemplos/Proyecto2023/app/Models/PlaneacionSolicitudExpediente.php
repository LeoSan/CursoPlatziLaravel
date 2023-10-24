<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlaneacionSolicitudExpediente extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'planeacion_solicitud_expedientes';

    protected $casts = ['fecha_solicitud'=>'date','fecha_expediente_fisico' => 'datetime:Y-m-d'];


    protected $fillable = [
        'numero_oficio',
        'regional_id',
        'mes',
        'fecha_solicitud',
        'auditor_jefe_regional_id',
        'auditor_realizo_solicitud',
        'auditor_asignado_id',
        'total_expdientes_solicitados',
        'estatus_id',
        'vencido',
        'expediente_fisico',
        'fecha_expediente_fisico',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    /**
     * Description : relaciones DB
    */
    public function regional(){
        return $this->belongsTo(CatalogoElemento::class,'regional_id');
    }
    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }
    public function creador(){
        return $this->belongsTo(User::class,'auditor_realizo_solicitud');
    }
    public function asignado(){
        return $this->belongsTo(User::class,'auditor_asignado_id');
    }
    public function planeacion_auditorias(){
        return $this->hasMany(PlaneacionAuditoria::class,'region_id','regional_id');
    }
    public function auditor_regional(){
        return $this->belongsTo(User::class,'auditor_jefe_regional_id');
    }
    public function gestion(){
        return $this->hasMany(GestionAuditoria::class,'planeacion_solicitud_expediente_id')->orderByDesc('created_at');
    }
    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }
    public function mes(){
        return $this->belongsTo(CatalogoElemento::class,'mes');
    }


}
