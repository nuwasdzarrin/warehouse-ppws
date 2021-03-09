<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\TransactionOut;
use Faker\Generator as Faker;

$factory->define(App\TransactionOut::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
