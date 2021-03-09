<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::count() == 0) {
            $roles = [
                ['name'=> 'superadmin','display_name'=> 'Super Admin'],
                ['name'=> 'admin','display_name'=> 'Admin'],
                ['name'=> 'staff','display_name'=> 'Staff'],
            ];
            foreach ($roles as $i) {
                Role::create($i);
            }
        }
    }
}
