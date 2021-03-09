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
         $this->call(RoleTableSeeder::class);
         $this->call(InstitutionTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(TransactionStatusTableSeeder::class);
         $this->call(ProductCategoryTableSeeder::class);
         $this->call(ProductTableSeeder::class);
    }
}
