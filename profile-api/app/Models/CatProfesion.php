<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProfesion extends Model
{
    use HasFactory;
    protected $table = 'cat_profesiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nom_categoria',
        'desc_categoria',
        'activo',
        'created_at',
        'updated_at',
        'delete_at'
    ];
}
