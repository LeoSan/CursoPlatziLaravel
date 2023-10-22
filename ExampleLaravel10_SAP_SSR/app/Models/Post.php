<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table='post';
    protected $guarded=[];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        //'deleted_at' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus',
    ];

}
