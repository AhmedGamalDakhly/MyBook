<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'id'=>$faker->uuid(),
        'email' => $faker->email(),
        'email_verified_at' => $faker->dateTime(),
        'password' => bcrypt('12345'), // password
        'remember_token' =>$faker->uuid(),
    ];
});
