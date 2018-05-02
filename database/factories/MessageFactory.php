<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class,function (Faker $faker) {
    return [
        'from_user_id' => factory(\App\User::class)->create()->id,
        'to_user_id' => factory(\App\User::class)->create()->id,
        'user' => factory(\App\User::class)->create()->id,
        'friend' => factory(\App\User::class)->create()->id,
        'body' => $faker->sentence,
    ];
});
