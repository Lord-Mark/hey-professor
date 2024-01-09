<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\{Question, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $myName     = 'Luan Mark';
        $myEmail    = 'mark@primeiramesa.com';
        $myPassword = bcrypt('123456');

        // Closure para criar meu usuário de autologin, mas aqui ainda não é executada
        $createMyUser = fn () => User::factory()->create([
            'name'     => $myName,
            'email'    => $myEmail,
            'password' => $myPassword,
        ]);

        // Se meu usuário não for encontrado, então cria o usuário utilizando a closure definida
        User::query()->where('email', $myEmail)->firstOr($createMyUser);

        Question::factory()->count(10)->create();

    }
}
