<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

     DB::table('roles')->insertOrIgnore([
            ['id' => Role::ADMIN,   'name' => 'admin'],
            ['id' => Role::DOCTOR,  'name' => 'doctor'],
            ['id' => Role::PATIENT, 'name' => 'patient'],
        ]);

        User::firstOrCreate(
            ['email' => 'admin@doctor.com'], 
            [
                'first_name'  => 'Frolian',
                'middle_name' => 'dev',
                'last_name'   => 'inc',
                'username'    => 'admin',
                'password'    => Hash::make('admin123'),
                'role_id'     => Role::ADMIN,
            ]
        );


    }
}
