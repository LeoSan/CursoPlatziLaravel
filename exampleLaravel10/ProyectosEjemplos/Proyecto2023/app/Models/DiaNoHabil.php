<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiaNoHabil extends Model
{
    use HasFactory;

    protected $table = 'dias_no_habiles';
    protected $casts = ['fecha'=>'date'];

    protected $fillable = [
        'fecha',
        'descripcion',
        'creador_id',
        'anio',
        'dependencia_id'
    ];
}
