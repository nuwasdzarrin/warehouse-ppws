<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\Test;
use Faker\Generator as Faker;

$factory->define(App\Test::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
