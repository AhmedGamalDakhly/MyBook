<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->uuid(),
        'path' => $faker->filePath(),
        'about' => $faker->text(),
        'name' => $faker->userName(), // password
        'first_name' =>$faker->firstNameMale(),
        'last_name' =>$faker->lastName(),
        'tag' => $faker->userName(),
        'gender' => 'male', // password
        'phone' =>$faker->numerify('010#######'),
        'status' => 'active',
        'date_of_birth' => $faker->dateTime(),
        'image' => 'default.png', // password
        'cover' =>'cover.jpg',
    ];
});
