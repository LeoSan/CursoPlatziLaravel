<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Caso extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='casos';
    protected $guarded=[];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
        'fecha_notificacion' => 'date:Y-m-d',
        'fecha_registro' => 'date:Y-m-d',
        'fecha_recepcion_pgr' => 'date:Y-m-d',
        'hora_notificacion' => 'datetime'
    ];

    public function departamento(){
        return $this->belongsTo(CatalogoElemento::class,'departamento_id');
    }
    public function municipio(){
        return $this->belongsTo(CatalogoElemento::class,'municipio_id');
    }
    public function estatus(){
        return $this->belongsTo(CatalogoElemento::class,'estatus_id');
    }
    public function empresa(){
        return $this->hasOne(Empresa::class,'caso_id');
    }
    public function sanciones(){
        return $this->hasMany(Sancion::class,'caso_id');
    }
    public function domicilio(){
        return $this->morphOne(Domicilio::class,'entidad');
    }
    public function getEnCapturaAttribute(){
        return isset($this->estatus) && $this->estatus->codigo=="captura";
    }
    public function inspector(){
        return $this->belongsTo(User::class,'creador_id')->withTrashed();
    }
    public function asignado(){
        return $this->belongsTo(User::class,'usuario_asignado_id');
    }
    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }

    public function gestion(){
        return $this->hasMany(GestionCaso::class,'caso_id')->orderByDesc('created_at');
    }

    public function resoluciones(){
        return $this->hasMany(Resolucion::class,'caso_id');
    }

    public function convenio(){
        return $this->hasOne(Convenio::class,'caso_id');
    }

    public function gestionMensajes(){
        return $this->hasMany(GestionCaso::class,'caso_id')
            ->whereHas('creador',function($q){
                $q->whereAreaAdscripcionId(Auth::user()->area_adscripcion_id);
            })
            ->where(function($query) {
                $query->where('observacion','!=',null)->orWhere('motivo_id','!=',null);
            })->orderByDesc('created_at');
    }

    public function pagostotales(){
        return $this->hasMany(PagoTotal::class,'caso_id');
    }

    public function getHasPagosVencidosAttribute(){
        return $this->convenio && $this->convenio->pagos->count() > 0 && $this->convenio->pagos->where('vencido',true)->where('pagado',false)->count() > 0;
    }

    public function getMultaPagadaAttribute(){
        return bccomp($this->total_cobrado,$this->total_multa,2) >= 0;
    }

    public function descargos(){
        return $this->hasMany(GestionCaso::class,'caso_id')
            ->whereHas('motivo',function($q){
                $q->whereCatalogo_id(Catalogo::whereCodigo('tipos_descargo')->first()->id);
            })->orderByDesc('created_at');
    }



}
