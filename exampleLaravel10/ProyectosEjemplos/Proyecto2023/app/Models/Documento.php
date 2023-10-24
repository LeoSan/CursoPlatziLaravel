<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documentos';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
        'fecha_recepcion' => 'datetime:Y-m-d',
        'fecha_oficio' => 'date:Y-m-d',
    ];
    protected $appends = [
        'codigo'
    ];

    protected $guarded = [];

    public function categoria()
    {
        return $this->belongsTo(CatalogoElemento::class, 'tipo_documento_id');
    }
    public function getCodigoAttribute(){
        return $this->categoria ? $this->categoria->codigo : null;
    }
}
