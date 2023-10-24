<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasoUsuario extends Model
{
    use HasFactory;

    protected $table = 'casos_usuarios';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function caso(){
        return $this->belongsTo(Caso::class,'caso_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }
}
