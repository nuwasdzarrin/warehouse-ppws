<?php

use Illuminate\Database\Seeder;
use App\TransactionStatus;

class TransactionStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (TransactionStatus::count() == 0) {
            $statuses = [
                ['name'=> 'Beli','type'=> 'in'],
                ['name'=> 'Jual','type'=> 'out'],
                ['name'=> 'Hibah','type'=> 'in'],
                ['name'=> 'Dipinjam','type'=> 'out'],
                ['name'=> 'Penyesuaian','type'=> 'in'],
                ['name'=> 'Penyesuaian','type'=> 'out'],
            ];
            foreach ($statuses as $i) {
                TransactionStatus::create($i);
            }
        }
    }
}
