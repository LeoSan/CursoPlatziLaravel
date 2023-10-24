<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{PermissionBlacklist, Role, Permission};

class UpdatePermisosUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditor = Role::where('name','=','auditor_setrass_ati')->first();
        $jefe_auditor = Role::where('name','=','jefe_auditoria_setrass_ati')->first();
        $permiso = Permission::where('name','ver_limitada_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        $auditor->givePermissionTo('ver_completa_bandeja_denuncias');
        $auditor->givePermissionTo('cargar_informe_auditoria');
        $auditor->givePermissionTo('respuesta_solicitud_expediente');
        $jefe_auditor->givePermissionTo('ver_completa_bandeja_denuncias');
        $jefe_auditor->givePermissionTo('respuesta_solicitud_expediente');
        $jefe_auditor->givePermissionTo('cargar_informe_auditoria');
        $role_jefe_regional_setrass =  Role::where('name','=','jefe_regional')->first();
        $role_jefe_regional_setrass->givePermissionTo('ver_limitada_bandeja_denuncias');
        $role_jefe_regional_setrass->givePermissionTo('consultar_denuncias');
        $role_jefe_regional_setrass->givePermissionTo('admitir_denuncias');
        $role_jefe_regional_setrass->givePermissionTo('respuesta_solicitud_expediente');
        $permiso = Permission::where('name','ver_completa_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_jefe_regional_setrass->id,'permission_id' => $permiso->id,]);
    }
}
