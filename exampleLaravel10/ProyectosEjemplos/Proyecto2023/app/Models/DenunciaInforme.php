<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    CatalogoElemento,
    Domicilio,
    GestionDenuncia,
    User};

use Carbon\Carbon;

class DenunciaInforme extends Model
{
    use HasFactory;
    protected $table = 'denuncia_informes';

    protected $fillable = [
        'denuncia_id',
        'observaciones',
        'visita_campo',
        'comentarios',
    ];

    /**
     * Description : Relaciones con la tabla
     */
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'denuncia_id', 'id');
    }

    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }

    public function adjuntos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad('informescomentarios');
    }

}
