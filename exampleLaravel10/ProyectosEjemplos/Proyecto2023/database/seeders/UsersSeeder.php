<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\{User, Catalogo, CatalogoElemento,Role, UsuarioJurisdiccion};


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Usuarios de SETRASS
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_id = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','dgit')->first()->id;
        $region = Catalogo::where('codigo', 'regiones_setrass')->first();
        $region_id= CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_ceiba')->first()->id;;
        $rol = Role::where('name','admin_setrass')->first()->id;
        User::updateOrCreate(
            ['email'=>'admin_setrass@fake.com'],
            [
                'name' => 'Administrador SETRASS',
                'first_name'=>'SETRASS',
                'last_name'=>'Honduras',
                'complete_name'=>'Administrador SETRASS Honduras',
                'email'=>'admin_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Administrador',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('admin_setrass');

        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $rol = Role::where('name','inspector_setrass')->first()->id;
        User::updateOrCreate(
            ['email'=>'inspector_setrass@fake.com'],
            [
                'name' => 'Inspector',
                'first_name'=>'SETRASS',
                'last_name'=>'Honduras',
                'complete_name'=>'Inspector SETRASS Honduras',
                'email'=>'inspector_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Inspector',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('inspector_setrass');

        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $rol = Role::where('name','analista_setrass')->first()->id;
        User::updateOrCreate(
            ['email'=>'analista_setrass@fake.com'],
            [
                'name' => 'Analista',
                'first_name'=>'SETRASS',
                'last_name'=>'Honduras',
                'complete_name'=>'Analista SETRASS Honduras',
                'email'=>'analista_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Analista',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('analista_setrass');

        //ATI
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $rol = Role::where('name','auditor_setrass_ati')->first()->id;
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_id = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','ati')->first()->id;
        User::updateOrCreate(
            ['email'=>'auditor_setrass@fake.com'],
            [
                'name' => 'Auditor',
                'first_name'=>'SETRASS',
                'last_name'=>'ATI',
                'complete_name'=>'Auditor SETRASS ATI',
                'email'=>'auditor_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Auditor',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('auditor_setrass_ati');
        $rol = Role::where('name','jefe_auditoria_setrass_ati')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_auditoria_setrass@fake.com'],
            [
                'name' => 'Jefe de Auditoria',
                'first_name'=>'SETRASS',
                'last_name'=>'ATI',
                'complete_name'=>'Jefe de Auditoria SETRASS ATI',
                'email'=>'jefe_auditoria_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe de Auditoria',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_auditoria_setrass_ati');

        //Usuarios de PGR

        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('pgr')->where('catalogo_id','=',$catalogo)->first()->id;
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_id = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','dnpj')->first()->id;
        $region = Catalogo::where('codigo', 'regiones_setrass')->first();
        $region_id= CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_comayagua')->first()->id;
        $rol = Role::where('name','administrador_dnpj')->first()->id;
        User::updateOrCreate(
            ['email'=>'admin_pgr@fake.com'],
            [
                'name' => 'Administrador PGR',
                'first_name'=>'PGR',
                'last_name'=>'Honduras',
                'complete_name'=>'Administrador PGR Honduras',
                'email'=>'admin_pgr@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Administrador',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('administrador_dnpj');

        $rol = Role::where('name','auxiliar_dnpj')->first()->id;
        User::updateOrCreate(
            ['email'=>'auxiliar_pgr@fake.com'],
            [
                'name' => 'Auxiliar',
                'first_name'=>'PGR',
                'last_name'=>'Honduras',
                'complete_name'=>'Auxiliar PGR Honduras',
                'email'=>'auxiliar_pgr@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Auxiliar',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('auxiliar_dnpj');

        $rol = Role::where('name','coordinador')->first()->id;
        User::updateOrCreate(
            ['email'=>'coordinador_pgr@fake.com'],
            [
                'name' => 'Coordinador',
                'first_name'=>'PGR',
                'last_name'=>'Honduras',
                'complete_name'=>'Coordinador PGR Honduras',
                'email'=>'coordinador_pgr@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Coordinador',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('coordinador');

        $rol = Role::where('name','procurador')->first()->id;
        User::updateOrCreate(
            ['email'=>'procurador_pgr@fake.com'],
            [
                'name' => 'Procurador',
                'first_name'=>'PGR',
                'last_name'=>'Honduras',
                'complete_name'=>'Procurador PGR Honduras',
                'email'=>'procurador_pgr@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Procurador',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('procurador');


        //AUDITORES ATI
        $catalogo = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $rol = Role::where('name','auditor_setrass_ati')->first()->id;
        $area = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_id = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','ati')->first()->id;
        User::updateOrCreate(
            ['email'=>'jose_carlos_moya@fake.com'],
            [
                'name' => 'José Carlos',
                'first_name'=>'Moya',
                'last_name'=>'Aceituno',
                'complete_name'=>'José Carlos Moya Aceituno',
                'email'=>'jose_carlos_moya@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Auditor',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('auditor_setrass_ati');

        User::updateOrCreate(
            ['email'=>'emerson_maradiaga@fake.com'],
            [
                'name' => 'Emerson Reniery',
                'first_name'=>'Maradiaga',
                'last_name'=>'Lainez',
                'complete_name'=>'Emerson Reniery Maradiaga Lainez',
                'email'=>'emerson_maradiaga@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Auditor',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('auditor_setrass_ati');

        User::updateOrCreate(
            ['email'=>'ambar_amaya@fake.com'],
            [
                'name' => 'Ambar Jahaira',
                'first_name'=>'Amaya',
                'last_name'=>'Carranza',
                'complete_name'=>'Ambar Jahaira Amaya Carranza',
                'email'=>'ambar_amaya@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Auditor',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('auditor_setrass_ati');


        //Usuarios Jefe Regionales
        $catalogo    = Catalogo::whereCodigo('dependencias')->first()->id;
        $dependencia = CatalogoElemento::whereCodigo('setrass')->where('catalogo_id','=',$catalogo)->first()->id;
        $area        = Catalogo::where('codigo', 'areas_adscripcion')->first();
        $area_id     = CatalogoElemento::where('catalogo_id', $area->id)->where('codigo','dgit')->first()->id;
        $region      = Catalogo::where('codigo', 'regiones_setrass')->first();
        $rol         = Role::where('name','jefe_regional')->first()->id;

        //Usuarios Jefe Regional Ceiba
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_ceiba')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_ceiba_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Ceiba',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Ceiba',
                'email'=>'jefe_regional_ceiba_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional Choluteca
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_choluteca')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_choluteca_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Choluteca',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Choluteca',
                'email'=>'jefe_regional_choluteca_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_comayagua
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_comayagua')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_comayagua_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Comayagua',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Comayagua',
                'email'=>'jefe_regional_comayagua_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_danli
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_danli')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_danli_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Danli',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Danli',
                'email'=>'jefe_regional_danli_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_el_progreso
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_el_progreso')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_progreso_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'El Progreso',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Progreso',
                'email'=>'jefe_regional_progreso_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_juticalpa
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_juticalpa')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_juticalpa_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Juticalpa',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Juticalpa',
                'email'=>'jefe_regional_juticalpa_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_la_esperanza
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_la_esperanza')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_esperanza_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Esperanza',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Esperanza',
                'email'=>'jefe_regional_esperanza_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_olanchito
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_olanchito')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_olanchito_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Olanchito',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Olanchito',
                'email'=>'jefe_regional_olanchito_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_puerto_cortes
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_puerto_cortes')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_puerto_cortes_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Puerto Cortes',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Puerto Cortes',
                'email'=>'jefe_regional_puerto_cortes_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        //Usuarios Jefe Regional reg_puerto_lempira
        $region_id   = CatalogoElemento::where('catalogo_id', $region->id)->where('codigo','reg_puerto_lempira')->first()->id;
        User::updateOrCreate(
            ['email'=>'jefe_regional_puerto_lempira_setrass@fake.com'],
            [
                'name' => 'Jefe Regional ',
                'first_name'=>'Puerto Lempira',
                'last_name'=>'Honduras',
                'complete_name'=>'Jefe Regional Puerto Lempira',
                'email'=>'jefe_regional_puerto_lempira_setrass@fake.com',
                'phone'=>'5547779988',
                'dependencia_id'=>$dependencia,
                'regional_id'=>$region_id,
                'area_adscripcion_id'=>$area_id,
                'cargo'=>'Jefe Regional',
                'perfil_id'=>$rol,
                'password'=>Hash::make('hola honduras')
            ])->assignRole('jefe_regional');

        $usuario = User::where('complete_name','José Carlos Moya Aceituno')->first()->id;
        $municipio = CatalogoElemento::whereCodigo('0501')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0506')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0511')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1804')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1006')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1601')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0401')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);

        $usuario = User::where('complete_name','Emerson Reniery Maradiaga Lainez')->first()->id;
        $municipio = CatalogoElemento::whereCodigo('0703')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1501')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0601')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0301')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);

        $usuario = User::where('complete_name','Ambar Jahaira Amaya Carranza')->first()->id;
        $municipio = CatalogoElemento::whereCodigo('0101')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0107')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1101')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1301')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0209')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('0201')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
        $municipio = CatalogoElemento::whereCodigo('1807')->first()->id;
        UsuarioJurisdiccion::updateOrCreate([
            'usuario_id'=>$usuario,
            'municipio_id'=>$municipio
        ]);
    }
}
