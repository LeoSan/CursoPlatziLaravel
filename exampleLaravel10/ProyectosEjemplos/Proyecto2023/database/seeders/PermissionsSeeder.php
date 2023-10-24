<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\{ Catalogo, CatalogoElemento, Seccion};

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seccion = Seccion::whereCodigo('gestion_usuarios')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Usuarios Service, roles y permisos', 'name' => 'gestionar_usuarios', 'description' => 'Permite dar de alta y editar usuarios, así como asignar roles, cargo, permisos y privilegios a un usuario en especifico']);

        //Catalogos
        $seccion = Seccion::whereCodigo('gestion_catalogos')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de catálogos', 'name' => 'gestionar_catalogos', 'description' => 'Permite consultar, agregar, actualizar elementos a los catálogos']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de tipos de infracción', 'name' => 'gestionar_tipos_infraccion', 'description' => 'Permite dar de alta y editar tipos de infracciones']);

        //días inhábiles
        $seccion = Seccion::whereCodigo('gestion_diasinhabiles')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de días inhábiles', 'name' => 'gestion_diasinhabiles', 'description' => 'Permite consultar, agregar, actualizar días inhábiles']);

        //Bitacora
        $seccion = Seccion::whereCodigo('gestion_bitacoras')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de bitacora', 'name' => 'gestionar_bitacoras', 'description' => 'Permite consultar el listado de la bitácora']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Visualizar toda la bitácora', 'name' => 'ver_toda_bitacoras', 'description' => 'Permite consultar el listado de la bitácora y sus filtros para el usuario.']);

        //Jurisdiccion
        $seccion = Seccion::whereCodigo('gestion_jurisdiccion')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de jurisdicción', 'name' => 'gestionar_jurisdiccion', 'description' => 'Permite consultar y administrar la jurisdicción']);

        //Denuncias
        $seccion = Seccion::whereCodigo('gestion_denuncias')->first();
        $catalogo = Catalogo::whereCodigo('modulos_setrass')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Consulta de denuncias',                   'name' => 'consultar_denuncias',            'description' => 'Permite consultar las denuncias']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestión de denuncias',                    'name' => 'gestionar_denuncias',            'description' => 'Permite consultar las denuncias']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ver toda la bandeja de denuncias',        'name' => 'ver_toda_bandeja_denuncias',     'description' => 'Permite consultar y ver todas denuncias en la bandeja']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ver bandeja de denuncias limitada',       'name' => 'ver_limitada_bandeja_denuncias', 'description' => 'Permite consultar y ver información limitada en la bandeja de denuncias']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ver bandeja de denuncias completa',       'name' => 'ver_completa_bandeja_denuncias', 'description' => 'Permite consultar y ver información completa en la bandeja de denuncias']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción Inadmisión',              'name' => 'ejecutar_inadmision',            'description' => 'Permite la visualización del boton Inadmisión']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción Alta denuncia',           'name' => 'ejecutar_alta_denuncia',         'description' => 'Permite la visualización del boton Alta denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción Providencia',             'name' => 'ejecutar_providencia',           'description' => 'Permite la visualización del boton Providencia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción Solicitar expediente',    'name' => 'ejecutar_solicitud_exp',         'description' => 'Permite la visualización del boton Solicitud de expediente']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Registrar denuncia',                      'name' => 'registrar_denuncias',            'description' => 'Permite al auditor o jefe de auditor generar una denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción para Desestimar ',        'name' => 'ejecutar_desestimar',            'description' => 'Permite la visualización del boton para desestimar una denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción para finaliza denuncia',  'name' => 'ejecutar_finalizacion',          'description' => 'Permite la visualización del boton para finalizar una denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecutar acción para reasignar auditor',  'name' => 'ejecutar_reasignar_auditor',     'description' => 'Ejecutar acción para reasignar auditor en una denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Cargar informe',                          'name' => 'cargar_informe_denuncia',        'description' => 'Cargar informe de la denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Comentar informe',                        'name' => 'comentar_informe_denuncia',      'description' => 'Comentar informe de la denuncia']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Admitir denuncias',                       'name' => 'admitir_denuncias',              'description' => 'Permite realizar admisiones de denuncias']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Permite enviar expediente inspeccion ',   'name' => 'enviar_expediente_inspeccion',   'description' => 'Permite enviar expediente inspeccion']);


        $seccion = Seccion::whereCodigo('gestion_casos')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Exportar casos',                      'name' => 'exportar_casos',                     'description' => 'Permite exportar información de la bandeja de casos']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Registrar caso',                      'name' => 'registrar_caso',                     'description' => 'Permite guardar cambios de un caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Guardar cambios caso',                'name' => 'guardar_cambios_caso',               'description' => 'Permite guardar cambios de un caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Enviar caso a revisión',              'name' => 'enviar_revision_caso',               'description' => 'Permite enviar caso a revisión']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Eliminar borrador caso',              'name' => 'eliminar_borrador_caso',             'description' => 'Permite enviar caso a revisión']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Rechazar caso',                       'name' => 'rechazar_caso',                      'description' => 'Permite rechazar caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'No procede caso',                     'name' => 'no_procede_caso',                    'description' => 'No procede caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Notificar a PGR',                     'name' => 'notificar_pgr_caso',                 'description' => 'Notificar a PGR']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Asignar a coordinador',               'name' => 'asignar_coordinador_caso',           'description' => 'Asignar a coordinador el caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Turnar a procurador',                 'name' => 'turnar_procurador_caso',             'description' => 'Turnar a procurador el caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Iniciar proceso',                     'name' => 'iniciar_proceso_caso',               'description' => 'Iniciar proceso del caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Resolución de pago total',            'name' => 'resolucion_caso_pago_total',         'description' => 'Resolución pago total del caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Resolución de convenio de pago',      'name' => 'resolucion_caso_convenio_pago',      'description' => 'Resolución convenio de pago del caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Resolución de proceso de demanda',    'name' => 'resolucion_caso_proceso_demanda',    'description' => 'Resolución proceso de demanda del caso']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Descargar reporte mensual de pagos',  'name' => 'descargar_reporte_pagos',            'description' => 'Permite descargar un reporte mensual de pagos']);

        $seccion = Seccion::whereCodigo('gestion_auditorias')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Planeación anual de auditorías',          'name' => 'auditorias_planeacion',           'description'  => 'Permite la creación, edición y eliminación de los Planes anuales de auditorías.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Ejecución de auditorías',                 'name' => 'auditorias_ejecucion',            'description'  => 'Permite la ejecución de las auditorías.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Solicitud de expedientes',                'name' => 'solicitud_expediente',            'description'  => 'Permite solicitar expedientes para auditorías.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Respuesta a solicitud de expedientes',    'name' => 'respuesta_solicitud_expediente',  'description'  => 'Permite dar respuesta a las solicitudes de expedientes para auditorías.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Solicitud Incumplimiento',                'name' => 'solicitud_incumplimiento',        'description'  => 'Solicitud Incumplimiento.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Registrar incumplimiento de auditorías',  'name' => 'incumplimiento_auditorias',       'description'  => 'Permite marcar una auditoría con estatus incumplimiento.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Cargar informe de auditorías',            'name' => 'cargar_informe_auditoria',        'description'  => 'Cargar informe de auditorías ejecutada.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Iniciar proceso de auditorías',           'name' => 'iniciar_proceso_auditorias',      'description'  => 'Permite iniciar el proceso de una auditoría.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Generar prórroga en adutoría',            'name' => 'prorroga_solicitud_expedientes',  'description'  => 'Permite extender una prorroga para la solciitud de expedientes.']);
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Reasignar auditor',                       'name' => 'reasignar_auditor',               'description'  => 'Permite reasignar al auditor asignado de una ejecución de auditoría.']);

        $seccion = Seccion::whereCodigo('gestion_plantillas')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestionar plantillas', 'name' => 'gestionar_plantillas', 'description' => 'Permite la creación, edición y eliminación de plantillas.']);

        $seccion = Seccion::whereCodigo('gestion_formularios')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Gestionar formularios', 'name' => 'gestionar_formularios', 'description' => 'Permite la creación, edición y eliminación de formularios.']);

        $seccion = Seccion::whereCodigo('gestion_denuncias')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id,   'show_name' => 'Admitir denuncias',                 'name' => 'admitir_denuncias',                  'description' => 'Permite realizar admisiones de denuncias' ]);

        $seccion = Seccion::whereCodigo('gestion_casos')->first();
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Otro descargo', 'name' => 'otro_descargo', 'description' => 'Permite otro descargo del caso']);
        $seccion = Seccion::whereCodigo('gestion_casos')->first();
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        Permission::updateOrCreate(['seccion_id' => $seccion->id, 'show_name' => 'Información pendiente', 'name' => 'informacion_pendiente', 'description' => 'Permite pasae el caso a información pendiente']);


    }
}
