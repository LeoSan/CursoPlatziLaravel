<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ Catalogo, CatalogoElemento, Role };


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $area_id = CatalogoElemento::whereCodigo('dgit')->first()->id;
        $role_admin_setras =  Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Administrador', 'name' => 'admin_setrass','area_id'=>$area_id]);
        $role_admin_setras->givePermissionTo('descargar_reporte_pagos');
        $role_admin_setras->givePermissionTo('exportar_casos');
        $role_admin_setras->givePermissionTo('gestionar_usuarios');
        $role_admin_setras->givePermissionTo('gestionar_bitacoras');
        $role_admin_setras->givePermissionTo('ver_toda_bitacoras');
        $role_admin_setras->givePermissionTo('gestionar_catalogos');
        $role_admin_setras->givePermissionTo('gestionar_tipos_infraccion');
        $role_admin_setras->givePermissionTo('gestion_diasinhabiles');
        $role_admin_setras->givePermissionTo('gestionar_plantillas');
        $role_admin_setras->givePermissionTo('gestionar_formularios');
        $role_admin_setras->givePermissionTo('gestionar_jurisdiccion');

        $role_analista_setras = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Analista', 'name' => 'analista_setrass','area_id'=>$area_id]);
        $role_analista_setras->givePermissionTo('rechazar_caso');
        $role_analista_setras->givePermissionTo('no_procede_caso');
        $role_analista_setras->givePermissionTo('notificar_pgr_caso');

        $role_inspector_setras = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Inspector', 'name' => 'inspector_setrass','area_id'=>$area_id]);
        $role_inspector_setras->givePermissionTo('eliminar_borrador_caso');
        $role_inspector_setras->givePermissionTo('enviar_revision_caso');
        $role_inspector_setras->givePermissionTo('guardar_cambios_caso');
        $role_inspector_setras->givePermissionTo('registrar_caso');

        $area_id = CatalogoElemento::whereCodigo('ati')->first()->id;
        //ATI
        $role_auditor_setras_ati = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Auditor', 'name' => 'auditor_setrass_ati','area_id'=>$area_id]);
        $role_auditor_setras_ati->givePermissionTo('consultar_denuncias');
        $role_auditor_setras_ati->givePermissionTo('ejecutar_alta_denuncia');
        $role_auditor_setras_ati->givePermissionTo('ejecutar_inadmision');
        $role_auditor_setras_ati->givePermissionTo('ejecutar_providencia');
        $role_auditor_setras_ati->givePermissionTo('ejecutar_solicitud_exp');
        $role_auditor_setras_ati->givePermissionTo('gestionar_denuncias');
        $role_auditor_setras_ati->givePermissionTo('registrar_denuncias');
        $role_auditor_setras_ati->givePermissionTo('ejecutar_desestimar');
        $role_auditor_setras_ati->givePermissionTo('ver_completa_bandeja_denuncias');
        $role_auditor_setras_ati->givePermissionTo('solicitud_expediente');

        $role_auditor_setras_ati->givePermissionTo('incumplimiento_auditorias');
        $role_auditor_setras_ati->givePermissionTo('iniciar_proceso_auditorias');

        $role_auditor_setras_ati->givePermissionTo('admitir_denuncias');
        $role_auditor_setras_ati->givePermissionTo('auditorias_ejecucion');
        $role_auditor_setras_ati->givePermissionTo('cargar_informe_denuncia');
        $role_auditor_setras_ati->givePermissionTo('prorroga_solicitud_expedientes');


        $role_jefe_auditoria_setras_ati = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Jefe de auditoría', 'name' => 'jefe_auditoria_setrass_ati','area_id'=>$area_id]);

        $role_jefe_auditoria_setras_ati->givePermissionTo('consultar_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_alta_denuncia');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_inadmision');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_providencia');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_solicitud_exp');
        $role_jefe_auditoria_setras_ati->givePermissionTo('gestionar_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('registrar_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ver_toda_bandeja_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ver_completa_bandeja_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_desestimar');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_reasignar_auditor');
        $role_jefe_auditoria_setras_ati->givePermissionTo('ejecutar_finalizacion');
        $role_jefe_auditoria_setras_ati->givePermissionTo('cargar_informe_denuncia');
        $role_jefe_auditoria_setras_ati->givePermissionTo('comentar_informe_denuncia');
        $role_jefe_auditoria_setras_ati->givePermissionTo('gestionar_plantillas');
        $role_jefe_auditoria_setras_ati->givePermissionTo('solicitud_expediente');

        $role_jefe_auditoria_setras_ati->givePermissionTo('solicitud_incumplimiento');
        $role_jefe_auditoria_setras_ati->givePermissionTo('incumplimiento_auditorias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('iniciar_proceso_auditorias');

        $role_jefe_auditoria_setras_ati->givePermissionTo('admitir_denuncias');
        $role_jefe_auditoria_setras_ati->givePermissionTo('auditorias_planeacion');
        $role_jefe_auditoria_setras_ati->givePermissionTo('auditorias_ejecucion');
        $role_jefe_auditoria_setras_ati->givePermissionTo('prorroga_solicitud_expedientes');
        $role_jefe_auditoria_setras_ati->givePermissionTo('reasignar_auditor');

        $denunciante = Role::firstOrCreate(['show_name' => 'Denunciante', 'name' => 'denunciante']);
        $denunciante->givePermissionTo('consultar_denuncias');
        $denunciante->givePermissionTo('ver_completa_bandeja_denuncias');

        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('pgr')->where('catalogo_id','=',$catalogo)->first()->id;
        $area_id = CatalogoElemento::whereCodigo('dnpj')->first()->id;
        $role_admin_pgr = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Administrador', 'name' => 'administrador_dnpj','area_id'=>$area_id]);
        $role_admin_pgr->givePermissionTo('gestionar_usuarios');
        $role_admin_pgr->givePermissionTo('gestionar_bitacoras');
        $role_admin_pgr->givePermissionTo('descargar_reporte_pagos');
        $role_admin_pgr->givePermissionTo('exportar_casos');

        $role_auxiliar_pgr = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Auxiliar', 'name' => 'auxiliar_dnpj','area_id'=>$area_id]);
        $role_auxiliar_pgr->givePermissionTo('asignar_coordinador_caso');


        $role_coordinador_pgr = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Coordinador', 'name' => 'coordinador','area_id'=>$area_id]);
        $role_coordinador_pgr->givePermissionTo('descargar_reporte_pagos');
        $role_coordinador_pgr->givePermissionTo('turnar_procurador_caso');
        $role_coordinador_pgr->givePermissionTo('rechazar_caso');
        $role_proocurador_pgr = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Procurador', 'name' => 'procurador','area_id'=>$area_id]);
        $role_proocurador_pgr->givePermissionTo('descargar_reporte_pagos');
        $role_proocurador_pgr->givePermissionTo('iniciar_proceso_caso');
        $role_proocurador_pgr->givePermissionTo('rechazar_caso');
        $role_proocurador_pgr->givePermissionTo('resolucion_caso_pago_total');
        $role_proocurador_pgr->givePermissionTo('resolucion_caso_convenio_pago');
        $role_proocurador_pgr->givePermissionTo('resolucion_caso_proceso_demanda');
        $role_proocurador_pgr->givePermissionTo('otro_descargo');
        $role_proocurador_pgr->givePermissionTo('informacion_pendiente');

        $catalogo = Catalogo::whereCodigo('modulos_setrass')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('modulo_ati')->where('catalogo_id','=',$catalogo)->first()->id;


        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $area_id = CatalogoElemento::whereCodigo('dgit')->first()->id;
        $role_jefe_regional_setrass = Role::firstOrCreate(['dependencia_id'=>$dependencia,'show_name' => 'Jefe Regional', 'name' => 'jefe_regional','area_id'=>$area_id]);
        $role_jefe_regional_setrass->givePermissionTo('enviar_expediente_inspeccion');
        $role_jefe_regional_setrass->givePermissionTo('ver_limitada_bandeja_denuncias');

    }
}
