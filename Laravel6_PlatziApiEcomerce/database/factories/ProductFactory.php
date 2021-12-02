<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'price' => $faker->numberBetween(10000, 60000),
        'categories_id' => rand(1,5)

    ];
});
