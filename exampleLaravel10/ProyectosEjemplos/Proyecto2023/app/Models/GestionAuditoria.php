<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAuditoria extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='gestion_auditorias';
    protected $guarded=[];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
        'fecha_solicitud' => 'datetime:Y-m-d',
        'fecha_notificacion_auditor' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'planeacion_solicitud_expediente_id',
        'estatus_id',
        'motivo_id',
        'observacion',
        'auditor_jefe_regional_id',
        'usuario_asignado_id',
        'creador_id',
        'notificado',
        'fecha_notificacion_auditor',
        'fecha_solicitud',
        'vencido'
    ];
    /**
     * Description : Relaciones con la tabla
    */

    public function asignado(){
        return $this->belongsTo(User::class,'usuario_asignado_id');
    }
    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class, 'estatus_id', 'id');
    }
    public function motivo(){
        return $this->belongsTo(CatalogoElemento::class, 'motivo_id', 'id');
    }

}
