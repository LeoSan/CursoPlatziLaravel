<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ Catalogo };

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Catálogo de Dependencias
        $dependencia = Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Dependencias',
            'codigo'=>'dependencias',
            'editable'=>true,
            'singular'=>'Dependencia'
        ]);

        //Catálogo de Estatus
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Estatus PGR',
            'codigo'=>'estatus_pgr',
            'editable'=>false
        ]);

        //Catálogo de Departamentos de Honduras
        $departamento = Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Departamentos',
            'codigo'=>'departamentos',
            'editable'=>true,
            'singular'=>'Departamento'
        ]);

        //Catálogo de Estatus
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Estatus Plan anual auditorías',
            'codigo'=>'estatus_plan_anual',
            'editable'=>false
        ]);

        //Catálogo de Estatus
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Estatus Auditorías',
            'codigo'=>'estatus_auditorias',
            'editable'=>false
        ]);

        //Catálogo de municipios de Honduras relacion Departamentos - Municipios
        $municipio = Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Municipios',
            'codigo'=>'municipios',
            'editable'=>true,
            'singular'=>'Municipio',
            'parent_id'=>$departamento->id
        ]);

        //Catálogo de Ciudades de Honduras relacion Municipios - Ciudades
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Ciudades',
            'codigo'=>'ciudades',
            'editable'=>true,
            'singular'=>'Ciudad',
            'parent_id'=>$municipio->id
        ]);

        //Catálogo de Tipo de Documentos
        Catalogo::updateOrCreate([
            'nombre'=>'Tipo de Documentos',
            'codigo'=>'documentos',
        ]);

        //Catálogo de Tipo de Documentos
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Sanciones',
            'codigo'=>'sanciones',
        ]);
        //Catálogo de Áreas de adscripción
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Áreas de adscripción',
            'codigo'=>'areas_adscripcion',
            'singular'=>'Área de adscripción',
            'parent_id'=>$dependencia->id
        ]);
        //Módulos
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Módulos Compartidos',
            'codigo'=>'modulos_compartidos'
        ]);
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Módulos SETRASS',
            'codigo'=>'modulos_setrass'
        ]);
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Módulos PGR',
            'codigo'=>'modulos_pgr'
        ]);

        //Catálogo de Regiones
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Regiones SETRASS',
            'codigo'=>'regiones_setrass',
            'editable'=>true
        ]);

        //Catálogo de Regiones
        Catalogo::updateOrCreate([
            'nombre'=>'Origen de la denuncia',
            'codigo'=>'origen_denuncia',
        ]);

        //Catálogo de Estatus Modulo Denuncias ATI
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Estatus Denuncia ATI',
            'codigo'=>'estatus_denuncia_ati',
            'editable'=>true
        ]);

        //Catálogo de Origen Denuncias ATI
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Origen Denuncia ATI',
            'codigo'=>'origen_denuncia_ati',
            'editable'=>false
        ]);

        //Catálogo de Desestimación Denuncias ATI
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Motivos de Desestimacion Denuncias ATI',
            'codigo'=>'desestimacion_denuncia_ati',
            'editable'=>false
        ]);

        //Catálogo de Inadmisión Denuncias ATI
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Motivos de Inadmisión Denuncia ATI',
            'codigo'=>'inadmision_denuncia_ati',
            'editable'=>false
        ]);

        //Catálogo de Motivos de Providencia Denuncias ATI
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Motivos de Providencia Denuncia ATI',
            'codigo'=>'providencia_denuncia_ati',
            'editable'=>false
        ]);

        //Catálogo de Motivos de Rechazo por el Coordinador
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Motivos de Rechazo por el Coordinador',
            'codigo'=>'rechazo_coordinador',
        ], [
            'editable'=>true,
        ]);

        //Catálogo de Motivos de Rechazo por el Procurador
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Motivos de Rechazo por el Procurador',
            'codigo'=>'rechazo_procurador',
        ], [
            'editable'=>true,
        ]);

        //Catálogo de Tipo de Pagos
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Tipo de Pagos',
            'codigo'=>'tipo_pagos',
            'editable'=>false
        ]);
        //Catálogo de Tipo de Pagos
        Catalogo::updateOrCreate([
            'nombre'=>'Medio de recepción',
            'codigo'=>'medio_recepcion',
            'editable'=>false
        ]);

        //Catálogo de Tipos de inspecciones
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Tipos de Inspección',
            'codigo'=>'tipos_inspeccion',
            'editable'=>false
        ]);

        //Catálogo de Carácter de denuncia
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Caracteres de Denuncias',
            'codigo'=>'caracteres_denuncia',
            'editable'=>false
        ]);

        //Catálogo de Actividades económicas
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de Actividades económicas',
            'codigo'=>'actividades_economicas',
            'editable'=>false
        ]);

        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de tipos de descargo',
            'codigo'=>'tipos_descargo',
            'editable'=>true
        ]);

        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de secciones para plantillas',
            'codigo'=>'secciones_plantillas',
            'editable'=>false,
            'singular'=>'Sección'
        ]);

        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de estatus para formularios',
            'codigo'=>'estatus_formularios',
            'editable'=>false
        ]);
        Catalogo::updateOrCreate([
            'nombre'=>'Catálogo de estatus para solicitud de expedientes auditoría',
            'codigo'=>'estatus_solicitud_expediente',
            'editable'=>false
        ]);
    }
}
