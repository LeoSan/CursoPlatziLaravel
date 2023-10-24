<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{PermissionBlacklist, Role, Permission};


class PermissionBlackListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin_setras = Role::where('name','=','admin_setrass')->first();
        $inspector = Role::where('name','=','inspector_setrass')->first();
        $analista = Role::where('name','=','analista_setrass')->first();
        $role_admin_pgr = Role::where('name','=','administrador_dnpj')->first();
        $auxiliar = Role::where('name','=','auxiliar_dnpj')->first();
        $coordinador = Role::where('name','=','coordinador')->first();
        $procurador = Role::where('name','=','procurador')->first();
        $auditor = Role::where('name','=','auditor_setrass_ati')->first();
        $jefe_auditor = Role::where('name','=','jefe_auditoria_setrass_ati')->first();
        $jefe_regional = Role::where('name','=','jefe_regional')->first();

        $permiso = Permission::where('name','ver_limitada_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','descargar_reporte_pagos')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','turnar_procurador_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','resolucion_caso_proceso_demanda')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','resolucion_caso_pago_total')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','resolucion_caso_convenio_pago')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','registrar_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','rechazar_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','notificar_pgr_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','no_procede_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','iniciar_proceso_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','guardar_cambios_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','exportar_casos')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','enviar_revision_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','eliminar_borrador_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

 

        $permiso = Permission::where('name','asignar_coordinador_caso')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestionar_tipos_infraccion')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestionar_catalogos')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ver_toda_bitacoras')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','consultar_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_alta_denuncia')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_inadmision')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_providencia')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_solicitud_exp')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestionar_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);


        $permiso = Permission::where('name','registrar_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ver_toda_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_desestimar')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestionar_plantillas')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestionar_bitacoras')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','gestion_diasinhabiles')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);        
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);

        
        $permiso = Permission::where('name','ver_completa_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);


        $permiso = Permission::where('name','informacion_pendiente')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','otro_descargo')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $inspector->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $analista->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        
        $permiso = Permission::where('name','ver_limitada_bandeja_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        
        $permiso = Permission::where('name','enviar_expediente_inspeccion')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_auditor->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auditor->id,'permission_id' => $permiso->id,]);
        
        

        $permiso = Permission::where('name','admitir_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','comentar_informe_denuncia')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','cargar_informe_denuncia')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','consultar_denuncias')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_finalizacion')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','ejecutar_reasignar_auditor')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','auditorias_ejecucion')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','auditorias_planeacion')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);

        $permiso = Permission::where('name','solicitud_expediente')->first();
        PermissionBlacklist::updateOrCreate(['role_id' => $jefe_regional->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $auxiliar->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $coordinador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $procurador->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_setras->id,'permission_id' => $permiso->id,]);
        PermissionBlacklist::updateOrCreate(['role_id' => $role_admin_pgr->id,'permission_id' => $permiso->id,]);


        
    }
}



