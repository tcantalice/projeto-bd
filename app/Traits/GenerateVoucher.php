<?php

use App\Enums\Vaga as VagaEnum;

trait GenerateVoucher
{
    /**
     * Recupera uma vaga vazia
     *
     * @return App\Models\Vaga
     */
    public function getFreeVacancy()
    {
        $vacancy = Vaga::where('VAG_ST_STATUS', VagaEnum::LIVRE)->first();
        return $vacancy;
    }

    /**
     * Gera um código para o voucher
     *
     * @param string $prefix
     * @return string
     */
    public function voucherCode($prefix)
    {
        return $prefix . str_pad(rand(0, pow(10, 3) - 1), 3, '0', STR_PAD_LEFT) . strtoupper(Str::random(1)) . rand(0, 9);
    }
}

