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

class Denuncia extends Model
{
    use HasFactory;
    protected $table = 'denuncias';

    protected $fillable = [
        'origen_id',
        'folio',
        'sindicato_denunciante',
        'nombre_denunciante',
        'primer_apellido_denunciante',
        'segundo_apellido_denunciante',
        'telefono_denunciante',
        'correo_denunciante',
        'dni_denunciante',
        'nombre_funcionario',
        'oficina_regional_id',
        'region_departamento_id',
        'region_municipio_id',
        'descripcion_denuncia',
        'cuenta_con_pruebas',
        'estatus_id',
        'usuario_asignado_id',
        'medio_recepcion_id',
    ];

    /**
     * Description : Relaciones con la tabla
     */
    public function departamento_region()
    {
        return $this->belongsTo(CatalogoElemento::class, 'region_departamento_id', 'id');
    }
    public function municipio_region()
    {
        return $this->belongsTo(CatalogoElemento::class, 'region_municipio_id', 'id');
    }
    public function estatus()
    {
        return $this->belongsTo(CatalogoElemento::class, 'estatus_id', 'id');
    }
    public function origen()
    {
        return $this->belongsTo(CatalogoElemento::class, 'origen_id', 'id');
    }
    public function domicilio(){
        return $this->morphOne(Domicilio::class,'entidad');
    }
    public function gestion_denuncia(){
        return $this->hasMany(GestionDenuncia::class,'denuncia_id', 'id')->orderBy('created_at');
    }
    public function gestion(){
        return $this->hasMany(GestionDenuncia::class,'denuncia_id')->orderByDesc('created_at');
    }
    public function asignado_a(){
        return $this->belongsTo(User::class, 'usuario_asignado_id', 'id')->withTrashed();
    }
    public function documentos(){
        return $this->hasMany(Documento::class,'entidad_id')->whereTipoEntidad($this->getMorphClass());
    }
    public function informe(){
        return $this->hasOne(DenunciaInforme::class,'denuncia_id')->orderByDesc('created_at');
    }
    public function informes(){
        return $this->hasMany(DenunciaInforme::class,'denuncia_id')->orderByDesc('created_at');
    }
    public function oficina(){
        return $this->belongsTo(CatalogoElemento::class, 'oficina_regional_id', 'id');
    }
    public function medio_recepcion(){
        return $this->belongsTo(CatalogoElemento::class, 'medio_recepcion_id', 'id');
    }

    public function inadmision(){
        $estatus_revision_inadmision = CatalogoElemento::where('codigo', 'revision_inadmision')->first()->id;
        $estatus_inadmision = CatalogoElemento::where('codigo', 'inadmision')->first()->id;
        return $this->hasOne(GestionDenuncia::class,'denuncia_id')->whereIn('estatus_id',[$estatus_inadmision,$estatus_revision_inadmision])->orderByDesc('created_at')->first();
    }

    public function solicitudExpedienteDGIT(string $estatus){
        $estatus_respuesta_solicitud = CatalogoElemento::where('codigo', $estatus)->first()->id;
        return $this->hasOne(GestionDenuncia::class,'denuncia_id')->where('estatus_id',$estatus_respuesta_solicitud)->orderByDesc('created_at')->first();
    }

    public function hasEstatus(string $codigo){
        return $this->gestion()->whereHas('estatus',function($q)use($codigo){$q->whereCodigo($codigo);})->exists();
    }

    public function tipoInspeccion(){
        return $this->belongsTo(CatalogoElemento::class,'tipo_inspeccion_id');
    }
    public function caracter(){
        return $this->belongsTo(CatalogoElemento::class,'caracter_id');
    }


    /**
     * Description : Accessors y Mutators
    */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre_denunciante .' '.$this->primer_apellido_denunciante .' '.$this->segundo_apellido_denunciante;

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

    public function pintarBordeEstatus(string $estatus_permitido, string $estatus_igualitario, string $estatus_providencia ){

        $estatus_no_fondo = 'finalizado';

        if ($this->estatus_id ==  obtenerIdCatalogoElementCodigo($estatus_igualitario)){
            return "bg-br-status-".$this->estatus->codigo;
        }else if ($this->estatus_id ==  obtenerIdCatalogoElementCodigo($estatus_providencia)){
            return "bg-br-status-".$this->estatus->codigo;
        }else if ($this->gestion()->whereHas('estatus',function($q)use($estatus_permitido){$q->whereCodigo($estatus_permitido);})->exists()
                    &&  !$this->gestion()->whereHas('estatus',function($q)use($estatus_no_fondo){$q->whereCodigo($estatus_no_fondo);})->exists()){
            return "bg-br-status-".$this->estatus->codigo;
        }
        return '';
    }

    public function getDiasSolicitudExpedienteAttribute()
    {
        return $this->calculoDias(intval(config('app.plazo_solicitud_expediente')));
    }

    public function getDiasVencimientoProvidenciaAttribute() {
        return $this->calculoDias(intval(config('app.plazo_vencimiento_providencias')));
    }

    public function getDiasVencimientoDenunciaAttribute() {
        return $this->calculoDias(intval(config('app.plazo_vencimiento_denuncia')));
    }

    public function calculoDias($plazo = 0)
    {
        $codigo = $this->estatus->codigo;

        $fecha_estatus = $this->gestion()->whereHas('estatus',function($q)use($codigo){
            $q->whereCodigo($codigo);
        })->first();

        $fechaInicio = date('Y-m-d', strtotime($fecha_estatus->created_at));
        $inicio = Carbon::create($fechaInicio. ' 00:00:00');
        $fin = Carbon::create(date('Y-m-d'). ' 00:00:00');
        $diasTranscurridos = $inicio->diffInDaysFiltered(function(Carbon $date) {
            $inhabil = DiaNoHabil::whereFecha($date->format('Y-m-d'))->first();
            if(!$inhabil)
                return $date->isWeekday();
        }, $fin);

        $diasFeriados = DiaNoHabil::where('anio', '=',date('Y') )->pluck('fecha')->toArray();

        if (in_array($fin->format('Y-m-d'), $diasFeriados) || $fin->isWeekend()) {
            $diasTranscurridos--;
        }

        return $plazo - $diasTranscurridos;
    }
}
