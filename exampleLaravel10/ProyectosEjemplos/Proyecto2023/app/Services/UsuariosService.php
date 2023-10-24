<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuariosService
{
    /**
     * @param $rol
     * @param $dependencia_id
     * @param $area_adscripcion_id
     * @param $regional_id
     * @param $email
     * @param $telefono
     * @param $nombres
     * @param $primer_apellido
     * @param $segundo_apellido
     * @param $password
     * @return object
     * Crea o actualiza un usuario y devuelve un objeto con nombre_usuario, email, password
     */
    public function registrarUsuario($rol,$dependencia_id,$area_adscripcion_id,$regional_id,$email,$telefono,$nombres,$primer_apellido,$segundo_apellido=null,$password=null){
        $new_password=true;
        $perfil = Role::whereName($rol)->firstOrFail();
        $password = $password ?? Str::random(8);
        $usuario = User::whereEmail($email)->first();
        if($usuario){
            $usuario->update([
                'name' => $nombres,
                'first_name' => $primer_apellido,
                'last_name' => $segundo_apellido,
                'complete_name' => $nombres.' '.$primer_apellido.' '.($segundo_apellido??''),
                'email' => $email,
                'phone'=> $telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $regional_id,
                'area_adscripcion_id'=> $area_adscripcion_id,
                'cargo'=> ucfirst($rol),
                'perfil_id'=> $perfil->id
            ]);
            $new_password=false;
        }
        else
            $usuario = User::create([
                'name' => $nombres,
                'first_name' => $primer_apellido,
                'last_name' => $segundo_apellido,
                'complete_name' => $nombres.' '.$primer_apellido.' '.($segundo_apellido??''),
                'email' => $email,
                'phone'=> $telefono,
                'dependencia_id'=> $dependencia_id,
                'regional_id'=> $regional_id,
                'area_adscripcion_id'=> $area_adscripcion_id,
                'cargo'=> ucfirst($rol),
                'perfil_id'=> $perfil->id,
                'password'=> Hash::make($password)
            ]);
        $usuario->assignRole($rol);
        return (object)[
            'id'=>$usuario->id,
            'nombre_usuario'=>$usuario->nombre_completo,
            'email'=> $usuario->email,
            'password'=>$password,
            'new_password'=>$new_password
        ];
    }
}
