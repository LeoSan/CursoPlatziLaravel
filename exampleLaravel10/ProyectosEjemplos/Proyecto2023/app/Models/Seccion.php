<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Seccion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'secciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'modulo_id'
    ];

    public function permisos()
    {
        return $this->hasMany(Permission::class);
    }
}
