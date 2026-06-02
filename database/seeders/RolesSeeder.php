<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Administrador', 'Custodio', 'Solicitante'];

        foreach ($roles as $nombre) {
            $existe = DB::table('roles')->where('nombre', $nombre)->exists();

            if (! $existe) {
                DB::table('roles')->insert([
                    'id'         => (string) Str::uuid(),
                    'nombre'     => $nombre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
