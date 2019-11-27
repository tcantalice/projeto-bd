<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClienteMensalista;
use Faker\Generator as Faker;

$factory->define(ClienteMensalista::class, function (Faker $faker) {
    return [
        'CLM_ID_MATRICULA' => $faker->numberBetween(100, 999),
        'CLM_DS_CPF' => $faker->randomNumber(3) . $faker->randomNumber(3) . $faker->randomNumber(3) . $faker->randomNumber(2),
        'CLM_DS_NOME' => implode(' ', [$faker->firstName(), $faker->lastName()]),
        'CLM_DT_NASCIMENTO' => $faker->date()
    ];
});
