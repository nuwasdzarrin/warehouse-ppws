<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use NamespacedApp\Role;
use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
