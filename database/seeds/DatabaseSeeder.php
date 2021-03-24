<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        App\Rol::create([
          'nombre' => 'Administrador'
        ]);

        App\User::create([
          'nombre'   => 'John Doe',
          'usuario'  => 'johndoe',
          'email'    => 'johndoe@mail.com',
          'password' => bcrypt(123456),
          'role_id'  => 1
        ]);

        $proveedores = [
          "N/A",
          "INTERNO",
          "LABTEST",
          "CARESENS",
          "BIOTECH",
          "KAESER",
          "EXTERNO",
          "ANNAR",
          "ORTHO CLINICAL",
          "KAIKA",
          "BIOREG",
          "JOHNSON",
          "BIOIN",
          "FIRST MEDICAL",
          "AIRE FRIO",
          "ORTHOSYSTEM",
          "FRESENIUS",
          "GBARCO",
          "SERVITRONICS",
          "GENERAL ELECTRIC",
          "INTERNMO",
        ];

        foreach($proveedores as $pro){
          \App\Proveedor::create([
            'nombre' => $pro,
            'tipo' => 'mantenimiento'
          ]);
        }
    }
}
