<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\Product;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
