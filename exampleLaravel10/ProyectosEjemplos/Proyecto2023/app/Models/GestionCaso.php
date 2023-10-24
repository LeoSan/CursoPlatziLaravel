<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionCaso extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='gestion_casos';
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d'
    ];

    public function caso(){
        return $this->belongsTo(Caso::class,'caso_id');
    }
    public function asignado(){
        return $this->belongsTo(User::class,'usuario_asignado_id')->withTrashed();
    }
    public function creador(){
        return $this->belongsTo(User::class,'creador_id')->withTrashed();
    }
    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }
    public function motivo(){
        return $this->belongsTo(CatalogoElemento::class,'motivo_id');
    }
}
