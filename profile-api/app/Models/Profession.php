<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;
    protected $table = 'profesiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'cate_profesion_id',
        'nom_profesion',
        'desc_profesion',
        'activo',
        'created_at',
        'updated_at',
        'delete_at'
    ];
}
