<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionDenuncia extends Model
{
    use HasFactory;
    protected $table = 'atencion_denuncia';

    protected $fillable = [
        'denuncia_id',
        'expediente_usuario_id',
        'notificacion_dgit',
        'num_expediente_dgit',
        'num_expediente',
        'observacion_alta',
        'admision_usuario_id',
        'visita',
        'correo_dgit',
        'fecha_recepcion_providencia'
    ];
}
