<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad_profession extends Model
{
    use HasFactory;
    protected $table = 'habilidad_professions';

    protected $fillable = [
        'id',
        'usuario_profesiones_id',
        'nom_habilidades',
        'created_at',
        'updated_at',
        'delete_at'
    ];
}
