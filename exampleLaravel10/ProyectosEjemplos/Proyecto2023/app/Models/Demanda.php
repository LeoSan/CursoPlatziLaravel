<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demanda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'demandas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caso_id',
        'resolucion_id',
        'fecha',
        'num_expediente',
        'nom_juzgado',
        'nom_juez'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $casts = [ 'fecha'=>'date:Y-m-d'];

    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }
}
