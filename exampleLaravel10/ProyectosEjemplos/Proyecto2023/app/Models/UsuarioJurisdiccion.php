<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioJurisdiccion extends Model
{
    use HasFactory;

    protected $table = 'usuario_jurisdiccion';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    public function region(){
        return $this->belongsTo(Caso::class,'region_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }
}
