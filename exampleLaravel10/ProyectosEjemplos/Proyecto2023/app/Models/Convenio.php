<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'convenios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caso_id',
        'resolucion_id',
        'num_pagos'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function caso(){
        return $this->belongsTo(Caso::class,'caso_id');
    }

    public function pagos(){
        return $this->hasMany(Pago::class,'convenio_id')->orderBy('fecha');
    }

    public function pendiente(){
        return $this->hasOne(Pago::class,'convenio_id')->where('pagado', false)->where('fecha', '<', date('Y-m-d'). ' 00:00:00');
    }
/*
    public function getPagos(){
        return $this->belongsTo(Pagos::class,'convenio_id');
    }*/
}
