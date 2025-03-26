<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'dni' => '12345678',                  
            'nombre' => 'Admin',                   
            'apellidoPaterno' => '',         
            'apellidoMaterno' => '',         
            'usuario' => 'Admin',                
            'password' => Hash::make('Admin2024.'), 
            'tipo' => 'Administrador',
            'telefono' => '',  
        ]);
    }
}
