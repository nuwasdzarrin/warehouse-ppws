<?php

use Illuminate\Database\Seeder;
use App\Institution;

class InstitutionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Institution::count() == 0) {
            $institutions = [
                ['name'=> 'Lembaga A','noted'=> 'catatan untuk lembaga a'],
                ['name'=> 'Lembaga B','noted'=> 'catatan untuk lembaga b'],
                ['name'=> 'Lembaga C','noted'=> 'catatan untuk lembaga c'],
                ['name'=> 'Lembaga D','noted'=> 'catatan untuk lembaga d'],
            ];
            foreach ($institutions as $i) {
                Institution::create($i);
            }
        }
    }
}
