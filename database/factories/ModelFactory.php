<?php
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Birthday::class, function (Faker\Generator $faker) {    
    $faker = Faker\Factory::create('ru_RU');
        $tempArr = explode(" ", $faker->name);
    return [
        'nameF' => $tempArr[0],
        'nameN' => $tempArr[1],
        'nameOt' => $tempArr[2],
        'dolzh' => $faker->jobTitle,
        'work' => $faker->company,
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'photo' => $faker->imageUrl($width = 960, $height = 427),
    ];
});
