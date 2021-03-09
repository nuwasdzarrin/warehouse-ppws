<?php

use Illuminate\Database\Seeder;
use App\Institution;
use App\ProductCategory;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Product::count() == 0) {
            $institution = Institution::query()->first();
            $category = ProductCategory::query()->first();
            if ($institution && $category) {
                $products = [
                    ['name'=> 'Meja Lipat','stock'=> 0,'noted'=> 'catatan untuk Meja Lipat','institution_id'=> $institution->id,'product_category_id'=>$category->id],
                    ['name'=> 'Meja Tamu','stock'=> 0,'noted'=> 'catatan untuk Meja Tamu','institution_id'=> $institution->id,'product_category_id'=>$category->id],
                    ['name'=> 'Meja Dapur','stock'=> 0,'noted'=> 'catatan untuk Meja Dapur','institution_id'=> $institution->id,'product_category_id'=>$category->id],
                    ['name'=> 'Meja Kelas','stock'=> 0,'noted'=> 'catatan untuk Meja Kelas','institution_id'=> $institution->id,'product_category_id'=>$category->id],
                ];
                foreach ($products as $i) {
                    Product::create($i);
                }
            }
        }
    }
}
