<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\{DiaNoHabil, CatalogoElemento, User, Role};

class DiasNoHabilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //Dias No habiles [Fechas Patrias, Fechas Navideñas]
    $dependencias_setras = CatalogoElemento::whereCodigo('setrass')->first()->id;
    $rol_admin_setras = Role::where('name', '=', 'admin_setrass')->first()->id;
    $user_admin_setras = User::where('perfil_id', '=', $rol_admin_setras)->first()->id;


        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2023/10/04',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2023',
        ]);


        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2023/10/05',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2023',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2023/10/06',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2023',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2023/12/25',
            'descripcion'=>'Navidad',
            'anio'=>'2023',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/01/01',
            'descripcion'=>'Año nuevo',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/03/28',
            'descripcion'=>'Jueves santo',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/03/29',
            'descripcion'=>'Viernes santo',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/04/14',
            'descripcion'=>'Día de las Américas',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/05/01',
            'descripcion'=>'Día del trabajador',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/09/15',
            'descripcion'=>'Día de la independencia',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/10/05',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/10/06',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/10/07',
            'descripcion'=>'Feriado morazánico',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2024/12/25',
            'descripcion'=>'Navidad',
            'anio'=>'2024',
        ]);

        DiaNoHabil::updateOrCreate([
            'creador_id'=>$user_admin_setras,
            'fecha'=>'2025/01/01',
            'descripcion'=>'Año nuevo',
            'anio'=>'2025',
        ]);

    }
}
