<?php

use App\Models\{Bitacora,Catalogo,CatalogoElemento,Permission,PermissionBlacklist,User,Role  };
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

//use Illuminate\Support\Facades\Log;

if (! function_exists('active_class')) {
    /**
     * @param  string  $fragmento_url
     * @return string
     */
    function active_class($fragmento_url)
    {
        return request()->is($fragmento_url) ? 'active' : '';
    }
}

if (! function_exists('url_activa')) {
    /**
     * @param  string  $fragmento_url
     * @return string
     */
    function url_activa($fragmento_url)
    {
        return request()->is($fragmento_url);
    }
}

if (! function_exists('getCatalogoElementos')) {
    /**
     * @param $codigoCatalogo
     * @param $orderBy
     * @return \Illuminate\Support\Collection
     * Devuelve la colección de elementos de un catálogo
     */
    function getCatalogoElementos($codigoCatalogo,$orderBy='orden'){
        $cat = Catalogo::whereCodigo($codigoCatalogo)->first();
        $elementos = CatalogoElemento::whereCatalogoId($cat->id)->orderBy($orderBy)->get();
        return $elementos;
    }
}

function inBlacklist($role_id, $permission){
    $result = false;
    $blacklist = PermissionBlacklist::where('role_id', $role_id)->where('permission_id', $permission->id)->first();
    if (isset($blacklist)){
        $result = true;
    }
    return $result;
}

function inPermiso($role_id, $permiso_id,$usuario_id){
    $result  = false;
    $rol = Role::where('id',$role_id)->first();
    $permiso = Permission::where('id',$permiso_id)->first();
    $tiene_permiso_rol = $rol->hasPermissionTo($permiso->name);
    $tiene_permiso_usuario = User::findOrFail($usuario_id)->hasPermissionTo($permiso->name);

    if($tiene_permiso_rol  == true || $tiene_permiso_usuario == true){
        $result  = true;
    }
    return $result;
}
function isPermiso($role_id, $permiso_id,$usuario_id){
    $rol = Role::where('id',$role_id)->first();
    $permiso = Permission::where('id',$permiso_id)->first();
    $tiene_permiso_rol = $rol->hasPermissionTo($permiso->name);
    $tiene_permiso_usuario = User::findOrFail($usuario_id)->hasPermissionTo($permiso->name);
    return $tiene_permiso_rol;
}

function inPrivilegio($permiso_id,$usuario_id){
    $permiso = Permission::where('id',$permiso_id)->first();
    $tiene_permiso_usuario = User::findOrFail($usuario_id)->hasPermissionTo($permiso->name);
    return $tiene_permiso_usuario;
}

if (! function_exists('valIsParentCatalogoElement')) {
    function valIsParentCatalogoElement($id)
    {
        if ( CatalogoElemento::where('parent_id', '=', $id)->count() > 0) return true;
        return false;
    }
}

function getNombreSistema($usuario_id){
    $usuario = User::where('id',$usuario_id)->withTrashed()->first();
    $rol = $usuario->roles()->first()->name;
    $sistema = '';
    if($rol =='jefe_auditoria_setrass_ati' || $rol=='auditor_setrass_ati'){
        $sistema = 'Sistema de Auditoría Técnica de la Inspección';
    }else{
        $sistema = 'Sistema de seguimiento a casos PGR';
    }
    return $sistema;
}

if (! function_exists('registroBitacora')) {
    function registroBitacora($modelo = null,$accion=null,$componente=null,$subcomponente=null,$descripcion=null,$datos=null,$usuario_id=null)
    {
        $usuario = User::find($usuario_id??Auth::id());
        /**
         * Se contempla esta validación ya que existe un Registro de demanda donde el usuario no realiza login en el sistema
         * Ya se realizó una reunión y se concluyó que no se registrará una bitácora para este tipo de caso.
         *
        */
        if ($usuario){
            try{
                $modelo_id = isset($modelo) ? $modelo->id : null;
                $modelo_type = isset($modelo) ? $modelo->getMorphClass() : null;
                $usuario_id = $usuario->id;
                $dependencia_id = $usuario->dependencia_id;
                $codigo_dependencia = $usuario->dependencia->codigo;
                Bitacora::create([
                    'usuario_id' => $usuario_id,
                    'componente' => $componente,
                    'subcomponente'=>$subcomponente,
                    'accion' => $accion,
                    'descripcion' => $descripcion,
                    'datos' => isset($datos) ? json_encode($datos) : null,
                    'dependencia_id' => $dependencia_id,
                    'codigo_dependencia' => $codigo_dependencia,
                    'usuario_ip' => @$_SERVER['REMOTE_ADDR']??'127.0.0.1',
                    'modelo_id' => $modelo_id,
                    'modelo_type' => $modelo_type,
                ]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
            }
        }
    }
}

if (! function_exists('obtenerCatalogoElementId')) {
    function obtenerCatalogoElementId($id)
    {
        return  CatalogoElemento::where('id', '=', $id)->pluck('nombre')->first();
    }
}

if (! function_exists('formatoFecha')) {
    function formatoFecha($fecha = null)
    {
        if ($fecha == null){
            return  date('d n Y H:m:s',strtotime($fecha)) . ' hrs.';
        }else{
            return  (completaCero(date('d')) . '/' .  ucfirst( (date('m')) ). '/' . date('Y') . ' ' . completaCero(date('h')) . ':' . completaCero(date('m')). ' ');
        }
    }

    function completaCero(int $valor)
    {
        if ($valor < 10) $valor = "0".$valor;
        return $valor;
    }
    function obtenerMes(int $valor){
        $meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
        return $meses[$valor];


    }
}

function obtenerFormatoFecha($fecha){
    $fecha = $fecha->format('d-m-Y');
    $array_fecha = explode('-',$fecha);
    $mes = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    return  $array_fecha[0]." de ".$mes[$array_fecha[1]-1]." de ". $array_fecha[2] ;
}

if (! function_exists('obtenerIdCatalogoElementCodigo')) {
    function obtenerIdCatalogoElementCodigo($codigo)
    {
        $elemento = CatalogoElemento::where('codigo', '=', $codigo)->orderBy('id', 'desc')->first();
        return  @$elemento->id ?? null;
    }
}


if (! function_exists('lempiras')) {
    /**
     * @param  string  $numero
     * @return string $numero_formateado
     */
    function lempiras($numero)
    {
        $numero = str_replace(',', '', str_replace('L ', '', $numero));
        //Divide el número en parte entera y parte decimal
        $partes = explode('.', $numero);
        $parte_entera = $partes[0];
        $parte_decimal = $partes[1]??'00';
        //Agrega comas para separar los miles en la parte entera
        $parte_entera_formateada = '';
        $longitud = strlen($parte_entera);
        for ($i = 0; $i < $longitud; $i++) {
            $parte_entera_formateada .= $parte_entera[$i];
            if (($longitud - $i - 1) % 3 == 0 && $i != $longitud - 1) {
                $parte_entera_formateada .= ',';
            }
        }
        //Formar el número formateado completo
        $numero_formateado = $parte_entera_formateada . '.' . $parte_decimal;
        return $numero_formateado;
    }
}
if (! function_exists('precargaEstatus')) {
    /**
     *
     * @return arrays $id_estatus
     */
    function precargaEstatus()
    {
        //Pre-Recarga
        $cat = Catalogo::whereCodigo('estatus_pgr')->first();
        $cat_estatus_array = CatalogoElemento::where('catalogo_id', '=', $cat->id)->where(function ($q) {
            //$q->where('codigo', 'pago_total')->orWhere('codigo', 'no_procedente')->orWhere('codigo', 'otro_descargo');
            $q->where('codigo', 'captura')->orWhere('codigo', 'revision')->orWhere('codigo', 'rechazado_analista')->orWhere('codigo', 'pendiente')->orWhere('codigo', 'rechazado_dnpj')->orWhere('codigo', 'sin_atender_pgr')->orWhere('codigo', 'turnado_coordinador')->orWhere('codigo', 'rechazado_coordinador')->orWhere('codigo', 'turnado_procurador')->orWhere('codigo', 'rechazado_procurador')->orWhere('codigo', 'proceso')->orWhere('codigo', 'demanda')->orWhere('codigo', 'convenio_pago')->orWhere('codigo', 'concluido')->orWhere('codigo', 'info_pendiente');
        })->orderBy('orden')->pluck('id')->toArray();
        return $cat_estatus_array;
    }
}

if (! function_exists('simplificarNumero')) {
    /**
     * @param  string  $numero
     */
    function simplificarNumero($numero)
    {
        switch ($numero){
            case bccomp($numero,"1000000000000000000000000000000",2)>0:
                return bcdiv($numero,"1000000000000000000000000000000",2).' q';
            case bccomp($numero,"1000000000000000000000000",2)>0:
                return bcdiv($numero,"1000000000000000000000000",2).' q';
            case bccomp($numero,"1000000000000000000",2)>0:
                return bcdiv($numero,"1000000000000000000",2).' T';
            case bccomp($numero,"1000000000000",2)>0:
                return bcdiv($numero,"1000000000000",2).' B';
            case bccomp($numero,"1000000",2)>0:
                return bcdiv($numero,"1000000",2).' M';
            case bccomp($numero,"1000",2)>0:
                return bcdiv($numero,"1000",2).' K';
            default:
                return bcadd("0",$numero,2);
        }
    }
}

function getNombreSistemaHtml($usuario_id){
    $usuario = User::where('id',$usuario_id)->withTrashed()->first();
    $rol = $usuario->roles()->first()->name;
    $sistema = '';
    if($rol =='jefe_auditoria_setrass_ati' || $rol=='auditor_setrass_ati'){
        $sistema = '<p class="app-name mb-0 mx-0">Sistema de Auditoría<br>
                Técnica de la Inspección</p>';
    }else{
        $sistema = '<p class="app-name mb-0 mx-0">Sistema de seguimiento<br>
                a casos PGR</p>';
    }
    return $sistema;
}
