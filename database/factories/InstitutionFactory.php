<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\Institution;
use Faker\Generator as Faker;

$factory->define(App\Institution::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
