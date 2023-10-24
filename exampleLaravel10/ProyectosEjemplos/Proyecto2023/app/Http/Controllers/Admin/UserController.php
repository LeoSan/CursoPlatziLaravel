<?php

namespace App\Http\Controllers\Admin;
use App\Mail\Notificacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{ User, Catalogo, CatalogoElemento, Seccion, Permission, Role, Caso};
Use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Jobs\ReasignarExpedientes;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /*
    Bandeja de usuarios
    Muestra la lista de usuarios activos dentro de la platarforma
    */
    public function index(){
        return view('admin/usuarios/index');
    }

    public function create(){
        $user =  User::findOrFail(Auth::id());
        if(old('area')!= null){
            $roles = Role::where('area_id',old('area'))->where('dependencia_id','=',$user->dependencia->id)->where('name','!=','denunciante')->get();
        }else{
            $roles = Role::where('dependencia_id','=',$user->dependencia->id)->where('name','!=','denunciante')->get();
        }
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        if($user->dependencia->codigo == 'setrass'){
            $areas = CatalogoElemento::where('catalogo_id', $area->id)->whereIn('codigo', ['dgit','ati'])->orderBy('nombre')->get();
            $region = Catalogo::where('codigo', 'regiones_setrass')->first();
        }else{
            $region = Catalogo::where('codigo', 'regiones_pgr')->first();
            $areas = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo', 'dnpj')->orderBy('nombre')->get();
        }
        $regiones = CatalogoElemento::where('catalogo_id', $region->id)->orderBy('nombre')->get();
        $editable=true;
        return view('admin.usuarios.create', compact('roles','editable','areas','regiones'));
    }

    public function store(Request $request)
    {
        $usuario_existe = User::where('email',$request->email)->onlyTrashed()->first();
        if($usuario_existe != null){
            $rules = [
            'nombre'          => 'required|string',
            'primer_apellido' => 'required|string',
            'email'           => 'required|email:filter',
            'telefono'        => 'required',
            'regional'        => 'required',
            'area'            => 'required',
            'cargo'           => 'required',
            'perfil'          => 'required'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio',
            'email.email'      => 'El correo electrónico no tiene estructura de correo',
            '*.string' => 'Cadena de texto',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $dependencia_id = auth()->user()->dependencia_id;
        $password = Str::random(6);
        $usuario = $usuario_existe;
        $role_actual = Role::where('id','=',$usuario->perfil_id)->first();
        $usuario->roles()->detach();
        $role = Role::where('id','=',$request->perfil)->first();
        User::where('id',$usuario->id)->withTrashed()->update(['name' => $request->nombre,
                'first_name' => $request->primer_apellido,
                'last_name' => $request->segundo_apellido,
                'complete_name' => $request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido,
                'phone'=> $request->telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $request->regional,
                'area_adscripcion_id'=> $request->area,
                'cargo'=> $request->cargo,
                'perfil_id'=> $request->perfil,
                'deleted_at'=> NULL,
                'password'=> Hash::make($password)
            ]);
        $usuario = User::where('id',$usuario_existe->id)->first();
        $mensaje='Se creó el usuario correctamente.';
        $role = Role::where('id','=',$request->perfil)->first();
        $usuario->assignRole($role->name);
        $nombre_sistema = getNombreSistema($usuario->id);
        Mail::to($request->email)->send(new Notificacion($usuario, 'creacion_cuenta', 'Bienvenido(a) al '.$nombre_sistema, ['password' => $password,'sistema'=>$nombre_sistema]));
        $data = [
            'usuario_accion'=>auth()->user()->id,
            'accion'=>'creacion_cuenta',
            'usuario_modificado'=>$usuario->id
        ];
        $descripcion = 'Se activo el usuario '.$request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido.' el cual ya se encontraba registrado.';
        registroBitacora($usuario,A_REGISTRAR,C_USUARIOS,null,$descripcion,$data);
        }
        if ($usuario_existe == null && !isset($request->user_id)){
        //Validando atributos
        $rules = [
            'nombre'          => 'required|string',
            'primer_apellido' => 'required|string',
            'email'           => 'required|email:filter|unique:users',
            'telefono'        => 'required',
            'regional'        => 'required',
            'area'            => 'required',
            'cargo'           => 'required',
            'perfil'          => 'required'
        ];
        $messages = [
            '*.required' => 'Campo obligatorio',
            'email.email'      => 'El correo electrónico no tiene estructura de correo.',
            'email.unique'      => 'El correo electrónico ya se encuentra registrado en el sistema.',
            '*.string' => 'Cadena de texto',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();
        $dependencia_id = auth()->user()->dependencia_id;
        $password = Str::random(6);
        $user = User::create([
                'name' => $request->nombre,
                'first_name' => $request->primer_apellido,
                'last_name' => $request->segundo_apellido,
                'complete_name' => $request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido,
                'email' => $request->email,
                'phone'=> $request->telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $request->regional,
                'area_adscripcion_id'=> $request->area,
                'cargo'=> $request->cargo,
                'perfil_id'=> $request->perfil,
                'password'=> Hash::make($password)
        ]);
        $mensaje='Se creó el usuario correctamente.';
        $role = Role::where('id','=',$request->perfil)->first();
        $user->assignRole($role->name);
        $nombre_sistema = getNombreSistema($user->id);
        Mail::to($request->email)->send(new Notificacion($user, 'creacion_cuenta', 'Bienvenido(a) al '.$nombre_sistema, ['password' => $password,'sistema'=>$nombre_sistema]));
        $data = [
            'usuario_accion'=>auth()->user()->id,
            'accion'=>'creacion_cuenta',
            'usuario_modificado'=>$user->id
        ];
        $descripcion = 'Creación del usuario '.$request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido.'.';
        registroBitacora($user,A_REGISTRAR,C_USUARIOS,null,$descripcion,$data);
        }else{
            if($usuario_existe == null && isset($request->user_id)){
                $rules = [
                'nombre'          => 'required',
                'primer_apellido' => 'required',
                'telefono'        => 'required',
                'regional'        => 'required',
                'area'            => 'required',
                'cargo'           => 'required',
                'perfil'          => 'required'
            ];
            $messages = [
                '*.required' => 'Campo obligatorio'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->validate();
            $usuario = User::find($request->user_id);
            $role_actual = Role::where('id','=',$usuario->perfil_id)->first();
            $usuario->roles()->detach();
            $dependencia_id = auth()->user()->dependencia_id;
            $role = Role::where('id','=',$request->perfil)->first();

            User::where('id',$request->user_id)->update(['name' => $request->nombre,
                'first_name' => $request->primer_apellido,
                'last_name' => $request->segundo_apellido,
                'complete_name' => $request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido,
                'phone'=> $request->telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $request->regional,
                'area_adscripcion_id'=> $request->area,
                'cargo'=> $request->cargo,
                'perfil_id'=> $request->perfil
            ]);

            $usuario->assignRole($role->name);
            $mensaje='Se actualizó el usuario correctamente.';

            $descripcionBitacora = 'Se actualizó el usuario '.$request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido.'.';
            $data = [
                'name' => $request->nombre,
                'first_name' => $request->primer_apellido,
                'last_name' => $request->segundo_apellido,
                'complete_name' => $request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido,
                'phone'=> $request->telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $request->regional,
                'area_adscripcion_id'=> $request->area,
                'cargo'=> $request->cargo,
                'perfil_id'=> $request->perfil
            ];
            registroBitacora($usuario,A_ACTUALIZAR,C_USUARIOS,null,$descripcionBitacora,$data);
            }

        }

        return redirect()->route('usuarios')->with('success',$mensaje);
    }
    public function show($usuario_id,$accion=null)
    {
        $usuario = User::find($usuario_id);
        $dependencia_id = auth()->user()->dependencia_id;
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        if($usuario->dependencia->codigo == 'setrass'){
            $areas = CatalogoElemento::where('catalogo_id', $area->id)->whereIn('codigo', ['dgit','ati'])->orderBy('nombre')->get();
            $region = Catalogo::where('codigo', 'regiones_setrass')->first();

        }else{
            $region = Catalogo::where('codigo', 'regiones_pgr')->first();
            $areas = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo', 'dnpj')->orderBy('nombre')->get();
        }
        $regiones = CatalogoElemento::where('catalogo_id', $region->id)->orderBy('nombre')->get();
        $editable = true;
        if($accion != null && $accion=='ver_detalle'){
            $editable=false;
            $catalogo_dependencias = Catalogo::whereCodigo('dependencias')->first()->id;
            $dependencia = CatalogoElemento::where('id', $dependencia_id)->first();
            $usuario = User::select('users.*','catalogo_elementos.nombre as dependencia_name','roles.show_name as rol_name','area.nombre as area','region.nombre as region')->join('catalogo_elementos', 'users.dependencia_id', '=', 'catalogo_elementos.id')->join('roles', 'users.perfil_id', '=', 'roles.id')->join('catalogo_elementos as area', 'users.area_adscripcion_id', '=', 'area.id')->join('catalogo_elementos as region', 'users.regional_id', '=', 'region.id')->where('users.id','=',$usuario_id)->first();
        }
        //Permisos
        $dependencia_id = $usuario->dependencia_id;
        $catalogo_dependencias = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::where('id', $dependencia_id)->first();
        $catalogo_dependencia = Catalogo::where('codigo', 'modulos_'.
            $dependencia->codigo)->first();
        $modulos_dependencia = CatalogoElemento::where('catalogo_id', $catalogo_dependencia->id)->orderBy('nombre')->get();
        $catalogo_modulos_compartidos = Catalogo::where('codigo', 'modulos_compartidos')->first();
        $modulos_compartidos = CatalogoElemento::where('catalogo_id', $catalogo_modulos_compartidos->id)->orderBy('nombre')->get();
        $modulos = $modulos_dependencia->merge($modulos_compartidos);
        $role = [];
        $permisos_role = [];
        $permisos_user = [];
        if ($usuario->roles->count() > 0){
            $role = Role::find($usuario->roles->pluck('id')->first());
            //PERMISOS ROLE
            $permisos_role = Permission::whereIn('id', @$role->permissions->pluck('id')->toArray())->where('dependencia_id','=',$dependencia_id)->orWhere('dependencia_id','=',null)->get();
            //PERMISOS USER
            $permisos_user = Permission::whereIn('id', @$usuario->permissions->pluck('id')->toArray())->where('dependencia_id','=',$dependencia_id)->orWhere('dependencia_id','=',null)->get();
        }

        $permisos_by_seccion = [];
        $permisos_by_modulo  = [];
        if (count($permisos_role) > 0 || count($permisos_user) > 0 ){
            $permisos_by_seccion = $permisos_role->merge($permisos_user)->groupBy('seccion_id');
            $permisos_by_modulo  = $permisos_role->merge($permisos_user)->groupBy('modulo_id');
        }
        $roles = Role::where('dependencia_id','=',$dependencia_id)->where('name','!=','denunciante')->get();
        return view('admin.usuarios.create', compact('usuario','roles','editable', 'modulos', 'permisos_role', 'permisos_user', 'permisos_by_seccion', 'permisos_by_modulo','roles','areas','regiones'));
    }
    public function permisos($usuario_id)
    {
        $usuario = User::find($usuario_id);
        $dependencia_id = $usuario->dependencia_id;
        $catalogo_dependencias = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::where('id', $dependencia_id)->first();
        $catalogo_dependencia = Catalogo::where('codigo', 'modulos_'.
            $dependencia->codigo)->first();
        $modulos_dependencia = CatalogoElemento::where('catalogo_id', $catalogo_dependencia->id)->orderBy('nombre')->get();
        $catalogo_modulos_compartidos = Catalogo::where('codigo', 'modulos_compartidos')->first();
        $modulos_compartidos = CatalogoElemento::where('catalogo_id', $catalogo_modulos_compartidos->id)->orderBy('nombre')->get();
        $modulos = $modulos_dependencia->merge($modulos_compartidos);
        $role = [];
        $permisos_role = [];
        $permisos_user = [];
        if ($usuario->roles->count() > 0){
            $role = Role::find($usuario->roles->pluck('id')->first());
            //PERMISOS ROLE
            $permisos_role = Permission::whereIn('id', @$role->permissions->pluck('id')->toArray())->where('dependencia_id','=',$dependencia_id)->orWhere('dependencia_id','=',null)->get();
            //PERMISOS USER
            $permisos_user = Permission::whereIn('id', @$usuario->permissions->pluck('id')->toArray())->where('dependencia_id','=',$dependencia_id)->orWhere('dependencia_id','=',null)->get();
        }
        $permisos_by_seccion = [];
        $permisos_by_modulo  = [];
        if (count($permisos_role) > 0 || count($permisos_user) > 0 ){
            $permisos_by_seccion = $permisos_role->merge($permisos_user)->groupBy('seccion_id');
            $permisos_by_modulo  = $permisos_role->merge($permisos_user)->groupBy('modulo_id');
        }
        $roles = Role::where('dependencia_id','=',$dependencia_id)->where('name','!=','denunciante')->get();
        return view('admin.usuarios.permisos', compact('usuario', 'modulos', 'permisos_role', 'permisos_user', 'permisos_by_seccion', 'permisos_by_modulo','roles'));
    }
    public function storePermisos(Request $request){
        $mensaje = "";
        $user = User::find($request->user_id);
        $permisos = $request->permisos;
        $role = Role::find($user->roles->pluck('id')->first());

        $permisos_role = Permission::whereIn('id', $role->permissions->pluck('id')->toArray())->pluck('id')->toArray();
        if (isset($permisos)){
            $permisos_user = Permission::whereIn('id', array_diff($permisos, $permisos_role))->pluck('name')->toArray();
        }else{
            $permisos_user = Permission::whereIn('id', $permisos_role)->pluck('name')->toArray();
        }
        $user->syncPermissions($permisos_user);

        $descripcionBitacora = 'Se actualizaron los permisos del usuario '.$user->complete_name.'.';
        registroBitacora($user,A_ACTUALIZAR,C_USUARIOS,SC_PERMISOS,$descripcionBitacora,$permisos);

        $mensaje = "Se actualizó el usuario correctamente.";
        return redirect()->route('usuarios')->with('success',$mensaje);

    }
    public function getElmentosEliminarUsuario(Request $request){
        if(!$request->ajax()){
            return \Response::json([
                'mensaje' => 'Error',
                'codigo' => 1,
            ], 404);
        }
        $dependencia_id = auth()->user()->dependencia_id;
        $usuario_eliminar = User::find($request->usuario_id);
        $perfil_name = $usuario_eliminar->perfil->name;

        //$usuarios = User::select('users.*')->where('users.dependencia_id','=',$dependencia_id)->where('users.id','!=',$request->usuario_id)->get();
        //dd($perfil);
        $usuarios = User::whereHas('roles', function($q) use($perfil_name){
            $q->where('name','=', $perfil_name); })->where('users.id','!=',$request->usuario_id)->get();
        if(($usuario_eliminar->area->codigo == 'dgit' || $usuario_eliminar->area->codigo == 'dnpj') && $usuario_eliminar->perfil->name != 'jefe_regional'){
        $casos = $usuario_eliminar->casos;
        $tipoEliminado ='';
        $footer_modal = '';
        if(count($usuarios)>0 && count($casos)>0){
            $tipoEliminado = 'con_casos';
            $html = '<p>Al realizar esta acción, los casos que tenga asignados ' .$usuario_eliminar->complete_name.' y que se encuentren en proceso deberán ser asignados a otro usuario para que puedan ser concluidos.</p>Asignar '.count($casos).' caso(s) a</p><input type="hidden" name="tipoEliminado" value="con_casos"><input type="hidden" name="usuario_eliminar" value="'.$request->usuario_id.'"><select class="form-select" aria-label="" name="usuario_reasignar" id="usuario_reasignar"><option selected value>Selecciona un usuario</option>';
                foreach ($usuarios as $usuario){
                    $html .= '<option value="'.$usuario->id.'">'.$usuario->complete_name.'</option>';
                }
                $html .= '</select>';

            }else{
                if(count($usuarios)==0 && count($casos)>0){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p>Se requiere al menos un usuario con el perfil ' .$usuario_eliminar->perfil->show_name.' para poder continuar.';
                    $footer_modal = "<button type='button' class='btn btn-default fw-semibold' data-bs-dismiss='modal'>Cancelar</button><a href='".route('usuarios.create')."' class='btn btn-secondary' >Dar de alta usuario</button>";
                }
                if(count($casos)==0){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p><strong>¿Está seguro de querer eliminar la cuenta de '.$usuario_eliminar->complete_name .' ?</strong></p><input type="hidden" name="tipoEliminado" value="sin_casos"><input type="hidden" name="usuario_id" value="'.$request->usuario_id.'">';
                }

            }

        }
        if($usuario_eliminar->area->codigo == 'ati'){
        $denuncias = $usuario_eliminar->denuncias;
        $auditorias= $usuario_eliminar->auditorias;

        $usuarios = User::whereHas('roles', function($q) use($perfil_name){
            $q->where('name','=', $perfil_name); })->where('users.id','!=',$request->usuario_id)->get();
        $tipoEliminado ='';
        $footer_modal = '';
        if(count($usuarios)>0 && (count($denuncias)>0 || count($auditorias)>0)){
            $tipoEliminado = 'con_casos';
            $html = '<p>Al realizar esta acción, las denuncias y auditorias que tenga asignados ' .$usuario_eliminar->complete_name.' y que se encuentren en proceso deberán ser asignados a otro usuario para que puedan ser concluidos.</p>Asignar '.count($denuncias).' denuncia(s) y '.count($auditorias).' auditoria(s) a</p><input type="hidden" name="tipoEliminado" value="con_casos"><input type="hidden" name="usuario_eliminar" value="'.$request->usuario_id.'"><select class="form-select" aria-label="" name="usuario_reasignar" id="usuario_reasignar"><option selected value>Selecciona un usuario</option>';
                foreach ($usuarios as $usuario){
                    $html .= '<option value="'.$usuario->id.'">'.$usuario->complete_name.'</option>';
                }
                $html .= '</select>';

            }else{
                if(count($usuarios)==0 && (count($denuncias)>0 || count($auditorias)>0)){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p>Se requiere al menos un usuario con el perfil ' .$usuario_eliminar->perfil->show_name.' para poder continuar.';
                    $footer_modal = "<button type='button' class='btn btn-default fw-semibold' data-bs-dismiss='modal'>Cancelar</button><a href='".route('usuarios.create')."' class='btn btn-secondary' >Dar de alta usuario</button>";
                }
                if(count($denuncias)==0 && count($auditorias)==0){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p><strong>¿Está seguro de querer eliminar la cuenta de '.$usuario_eliminar->complete_name .' ?</strong></p><input type="hidden" name="tipoEliminado" value="sin_casos"><input type="hidden" name="usuario_id" value="'.$request->usuario_id.'">';
                }


            }

        }
        if(($usuario_eliminar->area->codigo == 'dgit' || $usuario_eliminar->area->codigo == 'dnpj') && $usuario_eliminar->perfil->name == 'jefe_regional'){

        $denuncias = $usuario_eliminar->denuncias;
        $casos = $usuario_eliminar->casos;

        $usuarios = User::whereHas('roles', function($q) use($perfil_name){
            $q->where('name','=', $perfil_name); })->where('users.id','!=',$request->usuario_id)->get();
        $tipoEliminado ='';
        $footer_modal = '';
        if(count($usuarios)>0 && (count($denuncias)>0 || count($casos)>0)){
            $tipoEliminado = 'con_casos';
            $html = '<p>Al realizar esta acción, las denuncias y casos que tenga asignados ' .$usuario_eliminar->complete_name.' y que se encuentren en proceso deberán ser asignados a otro usuario para que puedan ser concluidos.</p>Asignar '.count($denuncias).' denuncia(s) y '.count($casos).' caso(s) a</p><input type="hidden" name="tipoEliminado" value="con_casos"><input type="hidden" name="usuario_eliminar" value="'.$request->usuario_id.'"><select class="form-select" aria-label="" name="usuario_reasignar" id="usuario_reasignar"><option selected value>Selecciona un usuario</option>';
                foreach ($usuarios as $usuario){
                    $html .= '<option value="'.$usuario->id.'">'.$usuario->complete_name.'</option>';
                }
                $html .= '</select>';

            }else{
                if(count($usuarios)==0 && (count($denuncias)>0 || count($casos)>0)){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p>Se requiere al menos un usuario con el perfil ' .$usuario_eliminar->perfil->show_name.' para poder continuar.';
                    $footer_modal = "<button type='button' class='btn btn-default fw-semibold' data-bs-dismiss='modal'>Cancelar</button><a href='".route('usuarios.create')."' class='btn btn-secondary' >Dar de alta usuario</button>";
                }
                if(count($denuncias)==0 && count($casos)==0){
                    $tipoEliminado = 'sin_casos';
                    $html = '<p><strong>¿Está seguro de querer eliminar la cuenta de '.$usuario_eliminar->complete_name .' ?</strong></p><input type="hidden" name="tipoEliminado" value="sin_casos"><input type="hidden" name="usuario_id" value="'.$request->usuario_id.'">';
                }


            }

        }

        return \Response::json([
            'mensaje' => '200',
            'html' => $html,
            'tipoEliminado' => $tipoEliminado,
            'footer_modal' => $footer_modal
        ], 200);
    }
    public function eliminarUsuario(Request $request){
        if($request->tipoEliminado == 'sin_casos'){
            $usuario = User::find($request->usuario_id);
            $descripcionBitacora = 'Se eliminó al usuario '.$request->nombre.' '.$request->primer_apellido.' '.$request->segundo_apellido.'.';
            registroBitacora($usuario,A_ELIMINAR,C_USUARIOS,null,$descripcionBitacora,['tipo_eliminacion'=>$request->tipoEliminado]);
            $usuario->delete();
            $mensaje = "El usuario se eliminó con éxito";
        }else{
            $usuario_eliminar = User::find($request->usuario_id);

            ReasignarExpedientes::dispatchSync($request->usuario_reasignar,$request->usuario_eliminar,auth()->user()->id);
            $mensaje = "Se eliminó al usuario y se reasignaron los casos al usuario seleccionado. Esta acción será notificada por correo electrónico.";
        }

        return redirect()->route('usuarios')->with('success',$mensaje);
    }

    public function getPerfilesByAreaId(Request $request){
        if (!$request->ajax()) {
            return Response::json([
                'mensaje' => 'Error en la petición'
            ], 404);
        }
        $area = CatalogoElemento::where('id',$request->area_id)->first();
        $roles = Role::where('area_id',$request->area_id)->get();
        $html="<option value=''>Selecciona el perfil</option>";
        foreach ($roles as $rol){
            $html.="<option value='{$rol->id}' data-codigo='{$rol->codigo}'>{$rol->show_name}</option>";
        }
        return Response::json([
            'html'=>$html
        ]);
    }
}
