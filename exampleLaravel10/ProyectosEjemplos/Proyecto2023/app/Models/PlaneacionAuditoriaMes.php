<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaneacionAuditoriaMes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planeacion_auditoria_meses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'planeacion_auditoria_id',
        'mes',
        'num_auditorias',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function auditoria(){
        return $this->belongsTo(PlaneacionAuditoria::class,'planeacion_auditoria_id');
    }
}
