<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{ Catalogo, CatalogoElemento, Seccion };

class SeccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Usuarios permisos y privilegios

        $catalogo_id = Catalogo::whereCodigo('modulos_compartidos')->first()->id;
        $modulo_id = CatalogoElemento::whereCodigo('configuracion')->whereCatalogoId($catalogo_id)->first()->id;
        Seccion::updateOrCreate([
            'nombre'=>'Seguridad y cargos',
            'codigo'=>'gestion_usuarios',
            'modulo_id'=>$modulo_id
        ]);
        Seccion::updateOrCreate([
            'nombre'=>'Gestión del catálogos',
            'codigo'=>'gestion_catalogos',
            'modulo_id'=>$modulo_id
        ]);
        Seccion::updateOrCreate([
            'nombre'=>'Gestión Bitácora',
            'codigo'=>'gestion_bitacoras',
            'modulo_id'=>$modulo_id
        ]);
        Seccion::updateOrCreate([
            'nombre'=>'Gestión Jurisdicción',
            'codigo'=>'gestion_jurisdiccion',
            'modulo_id'=>$modulo_id
        ]);

        Seccion::updateOrCreate([
            'nombre'=>'Gestión de días inhábiles',
            'codigo'=>'gestion_diasinhabiles',
            'modulo_id'=>$modulo_id
        ]);


        Seccion::updateOrCreate([
            'nombre'=>'Gestión de formularios',
            'codigo'=>'gestion_formularios',
            'modulo_id'=>$modulo_id
        ]);

        $modulo_id = CatalogoElemento::whereCodigo('casos')->whereCatalogoId($catalogo_id)->first()->id;
        Seccion::updateOrCreate([
            'nombre'=>'Gestión de casos',
            'codigo'=>'gestion_casos',
            'modulo_id'=>$modulo_id
        ]);

        //Modulos SETRASS
        $catalogo_id = Catalogo::whereCodigo('modulos_setrass')->first()->id;
        $modulo_id = CatalogoElemento::whereCodigo('modulo_ati')->whereCatalogoId($catalogo_id)->first()->id;
        Seccion::updateOrCreate([
            'nombre'=>'Gestión Denuncias',
            'codigo'=>'gestion_denuncias',
            'modulo_id'=>$modulo_id
        ]);
        Seccion::updateOrCreate([
            'nombre'=>'Gestión de plantillas',
            'codigo'=>'gestion_plantillas',
            'modulo_id'=>$modulo_id
        ]);

        $modulo_id = CatalogoElemento::whereCodigo('auditorias')->whereCatalogoId($catalogo_id)->first()->id;
        Seccion::updateOrCreate([
            'nombre'=>'Gestión de auditorias',
            'codigo'=>'gestion_auditorias',
            'modulo_id'=>$modulo_id
        ]);


    }
}
