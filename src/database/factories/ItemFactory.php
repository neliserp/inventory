<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Neliserp\Inventory\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->numerify('I-####'),
        'name' => $faker->sentence,
    ];
});
