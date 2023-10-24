<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CatalogosSeeder::class,
            CatalogoElementosSeeder::class,
            TipoInfraccionSeeder::class,
            SeccionesSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            PermissionBlackListSeeder::class,
            DiasNoHabilesSeeder::class,
            UpdatePermisosUsuariosSeeder::class,
            PlantillasSeeder::class,
            FormulariosSeeder::class
        ]);
    }
}
