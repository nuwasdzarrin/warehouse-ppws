<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
use App\Institution;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductCategory::count() == 0) {
            $institution = Institution::query()->first();
            if ($institution) {
                $categories = [
                    ['name'=> 'Meja','institution_id'=> $institution->id],
                    ['name'=> 'Kursi','institution_id'=> $institution->id],
                    ['name'=> 'Papan Tulis','institution_id'=> $institution->id],
                    ['name'=> 'Spidol','institution_id'=> $institution->id],
                ];
                foreach ($categories as $i) {
                    ProductCategory::create($i);
                }
            }
        }
    }
}
