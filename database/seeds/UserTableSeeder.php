<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Institution;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'superadmin')->firstOrFail();
            $institution = Institution::query()->first();
            if ($role && $institution) {
                User::create([
                    'name'           => 'Admin',
                    'email'          => 'admin@admin.com',
                    'password'       => bcrypt('password'),
                    'remember_token' => \Illuminate\Support\Str::random(60),
                    'role_id'        => $role->id,
                    'institution_id'        => $institution->id,
                ]);
            }
        }
    }
}
