<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model };

class CatalogoElemento extends Model
{
    use HasFactory;

    protected $table = 'catalogo_elementos';

    protected $fillable = [
        'catalogo_id',
        'nombre',
        'codigo',
        'descripcion',
        'orden',
        'parent_id',
        'categoria_id',
    ];
    /**
     * Description : Relaciones con la tabla
     */
    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }
    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'modulo_id');
    }
    public function hijos(){
        return $this->hasMany(CatalogoElemento::class,'parent_id');
    }
    public function padre(){
        return $this->belongsTo(CatalogoElemento::class,'parent_id');
    }
    public function categoria()
    {
        return $this->belongsTo(CatalogoElemento::class, 'categoria_id');
    }
    public function jurisdiccion()
    {
        return $this->hasOne(UsuarioJurisdiccion::class, 'municipio_id');
    }
    /**
     * Description : Accessors y Mutators
    */
    public function getEntidadAttribute(){
        return CatalogoElemento::whereCodigo($this->descripcion)->first()->nombre??'N/A';
    }
    public function getCampoDescripcionAttribute()
    {
        $descripcion = $this->descripcion;
        if(empty($descripcion)) $descripcion ='<p class="no-data-message">Sin datos.</p>';
        return $descripcion;
    }

}
