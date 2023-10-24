<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoTotal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_totales';

    protected $fillable = [
        'caso_id',
        'resolucion_id',
        'fecha',
        'num_recibo',
        'monto',
        'interes',
        'tipo_pago_id',
        'monto_total'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $casts = [ 'fecha'=>'date:Y-m-d'];

    public function tipoPago(){
        return $this->belongsTo(CatalogoElemento::class,'tipo_pago_id');
    }
}
