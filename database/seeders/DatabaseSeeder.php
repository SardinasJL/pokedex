<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use App\Models\Tipo;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(["name" => "admin", "email" => "admin@admin.com", "password" => "12345678"]);
        Tipo::insert([
            ["descripcion" => "eléctrico"],
            ["descripcion" => "fuego"],
            ["descripcion" => "agua"],
        ]);
        Pokemon::insert([
            ["nombre" => "Pikachu", "altura" => 0.45, "peso" => 10, "foto" => "pikachu.png", "tipos_id" => 1],
            ["nombre" => "Charmander", "altura" => 0.7, "peso" => 15, "foto" => "charmander.png", "tipos_id" => 2],
            ["nombre" => "Squirtle", "altura" => 0.6, "peso" => 25, "foto" => "squirtle.png", "tipos_id" => 3],
        ]);
    }
}
