<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

    return [
        'title' => $faker->sentence(),
        'organizer' => $faker->randomElement([$faker->sentence(), null]),
        'description' => $faker->randomElement([$faker->paragraph(), null]),
        'url' => $faker->url,
        'image_url' => $faker->randomElement([$faker->picsumUrl(), null]),
        'date' => $faker->dateTimeInInterval('now', '+ 5 days', 'Europe/Rome'),
        'approved' => $faker->boolean(30)
    ];
});


