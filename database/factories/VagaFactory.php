<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\TipoCliente as TipoClienteEnum;
use App\Enums\Vaga as VagaEnum;
use App\Models\Vaga;
use Faker\Generator as Faker;

$factory->define(Vaga::class, function (Faker $faker) {
    return [
        'VAG_ST_SITUACAO' => VagaEnum::LIVRE,
        'VAG_FK_TIPO_CLIENTE' => TipoClienteEnum::HORISTA
    ];
});
