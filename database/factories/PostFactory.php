<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        'id'=>$faker->uuid(),
        'user_id'=>$faker->uuid(),
        'text' => $faker->text(100),
        'page_id'=>$faker->uuid(),
        'image' => $faker->text(20),
        'likers'=>serialize(array()),

    ];
});
