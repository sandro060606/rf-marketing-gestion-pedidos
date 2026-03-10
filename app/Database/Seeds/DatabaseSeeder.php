<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {   
        /* Orden de Ejecucion de las Semillas */
        $this->call(AreasSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(EmpresasSeeder::class);

    }
}
