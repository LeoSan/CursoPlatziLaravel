<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'convenio_id',
        'monto',
        'monto_pagado',
        'intereses',
        'monto_pagado_intereses',
        'num_recibo',
        'fecha',
        'fecha_pagado',
        'num_pago',
        'vencido',
        'fecha_vencimiento',
        'pagado',
        'prima'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $casts = [ 'fecha'=>'date:Y-m-d', 'fecha_pagado'=>'date:Y-m-d'];

    public function convenio() {
        return $this->belongsTo(Convenio::class,'convenio_id');
    }
}
