<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inhabil extends Model
{
    use HasFactory;
    protected $table='inhabiles';
    protected $guarded=[];

    protected $fillable = [
        'fecha',
        'plataforma_id',
        'descripcion',
        'persona_id',
    ];
}
