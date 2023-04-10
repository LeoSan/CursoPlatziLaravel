<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia_profession extends Model
{
    use HasFactory;

    protected $table = 'experiencia_professions';

    protected $fillable = [
        'id',
        'usuario_profesiones_id',
        'jornada_id',
        'nom_empresa',
        'desc_empresa',
        'cargo_empresa',
        'created_at',
        'updated_at',
        'delete_at'
    ];
}
