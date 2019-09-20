<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\UserProfile;
use Faker\Generator as Faker;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'bio' => $faker->paragraph,
    ];
});
