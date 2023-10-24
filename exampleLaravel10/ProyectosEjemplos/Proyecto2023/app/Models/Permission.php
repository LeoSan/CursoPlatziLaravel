<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, SoftDeletes;
    protected $appends = [
        'modulo_id',
    ];

    public function getModuloIdAttribute()
    {
        return $this->seccion()->first()->modulo_id;
    }

    public function modulo()
    {
        return $this->belongsTo(CatalogoElemento::class, 'modulo_id');
    }


    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
