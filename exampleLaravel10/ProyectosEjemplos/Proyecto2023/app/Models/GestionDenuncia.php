<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionDenuncia extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='gestion_denuncia';
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
        'fecha_recepcion' => 'date',
    ];
    
    protected $fillable = [
        'denuncia_id',
        'estatus_id',
        'usuario_asignado_id',
        'motivo_id',
        'observacion',
        'creador_id',
        'notificado',
        'fecha_notificacion_denunciante',
        'fecha_notificacion_auditor',
        'fecha_recepcion',
        'vencido'
    ];
    /**
     * Description : Relaciones con la tabla
    */
    public function caso(){
        return $this->belongsTo(Denuncia::class,'caso_id');
    }
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
