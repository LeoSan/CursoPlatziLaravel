<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarioprofesion extends Model
{
    use HasFactory;
    protected $table = 'usuario_profesiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'professions_id',
        'users_id',
        'desc_bio',
        'contacto_uno',
        'contacto_dos',
        'enlace_uno',
        'enlace_uno',
        'created_at',
        'updated_at',
        'delete_at'
    ];

    public function profession(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Profession::class,'id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'id');
    }


}
