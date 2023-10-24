<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='empresas';
    protected $guarded=[];
    protected $dates=['created_at','updated_at','deleted_at'];

    public function caso(){
        return $this->belongsTo(Caso::class,'caso_id');
    }
    public function representante(){
        return $this->hasOne(RepresentanteLegal::class,'empresa_id');
    }
}
