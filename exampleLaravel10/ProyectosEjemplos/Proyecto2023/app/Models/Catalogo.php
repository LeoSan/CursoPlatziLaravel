<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model };

class Catalogo extends Model
{
    use HasFactory;

    protected $table = 'catalogos';
    protected $fillable = [
        'nombre',
        'codigo',
        'singular',
        'parent_id'
    ];

    /**
     * Description : Relaciones con la tabla
     */
    public function elementos(){
        return $this->hasMany(CatalogoElemento::class,'catalogo_id')->orderBy('orden');
    }

    /**
     * Relación 1-N a los catálogos Hijos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hijos(){
        return $this->hasMany(Catalogo::class,'parent_id');
    }

    /**
     * Relación al catálogo padre
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function padre(){
        return $this->belongsTo(Catalogo::class,'parent_id');
    }
}
