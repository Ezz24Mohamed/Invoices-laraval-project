<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=user::create([
            'name'=>'Ezz eldin Mohamed',
            'email'=>'ezzeldinmohameed025@gmail.com',
            'password'=>bcrypt('12345678'),
        ]);
    }
}
