<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\Transaction;
use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
