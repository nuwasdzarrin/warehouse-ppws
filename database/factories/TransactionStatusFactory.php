<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\TransactionStatus;
use Faker\Generator as Faker;

$factory->define(App\TransactionStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
