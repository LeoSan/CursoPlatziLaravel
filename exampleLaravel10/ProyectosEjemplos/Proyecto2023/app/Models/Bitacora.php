<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{CatalogoElemento};

class Bitacora extends Model
{
    protected $table = 'bitacora';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'componente',
        'subcomponente',
        'descripcion',
        'datos',
        'tipo_plataforma',
        'usuario_ip',
        'componente_id',
        'tipo_componente',
        'accion',
        'dependencia_id',
        'codigo_dependencia',
        'modelo_id',
        'modelo_type'
    ];
    protected $dates = ['created_at'];


    /**
     * Description : Relaciones con la tabla
     */
    public function usuario(){
        return $this->hasOne(User::class,'id','usuario_id')->withTrashed();
    }
    public function dependencia(){
        return $this->belongsTo(CatalogoElemento::class, 'dependencia_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     * Devuelve el modelo al cual está relacionado polimórficamente el registro [Caso,Denuncia,Pago,Etc]
     */
    public function modelo(){
        return $this->morphTo();
    }
    /**
     * Description : Accessors y Mutators
    */
    public function getCampoDatosAttribute()
    {
        $datos = $this->datos;
        if(empty($this->datos)) $datos ='<p class="no-data-message">Sin datos.</p>';
        return $datos;
    }
    public function getFechaRegistroAttribute()
    {
        $dt = $this->created_at;
        return is_null($this->created_at) ? '-' : ($this->completaCero($dt->day) . ' ' .  ucfirst( $dt->monthName ). ' ' . $dt->year . ' ' . $this->completaCero($dt->hour) . ':' . $this->completaCero($dt->minute). ' hrs.');
    }
    /**
     * Description : Metodos
    */
    public function completaCero(int $valor)
    {
        if ($valor < 10) $valor = "0".$valor;
        return $valor;
    }
}
