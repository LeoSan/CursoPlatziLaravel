<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resolucion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resoluciones';

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
        'fecha' => 'datetime'
    ];

    public function tipo(){
        return $this->belongsTo(CatalogoElemento::class,'tipo_resolucion_id');
    }

    public function convenio(){
        return $this->hasOne(Convenio::class,'resolucion_id');
    }

    public function demanda(){
        return $this->hasOne(Demanda::class,'resolucion_id');
    }

    public function pagototal(){
        return $this->hasOne(PagoTotal::class,'resolucion_id');
    }

    public function motivo(){
        return $this->belongsTo(CatalogoElemento::class,'motivo_id');
    }
}
