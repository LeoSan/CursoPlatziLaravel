<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;
    protected $table = 'Membresias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nom_membresia',
        'desc_membresia',
        'precio',
        'activo',
        'created_at',
        'updated_at',
        'delete_at'
    ];
}
