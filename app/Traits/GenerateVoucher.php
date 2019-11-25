<?php
namespace App\Traits;


use Carbon\Carbon;
use App\Models\Vaga;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\Vaga as VagaEnum;
use App\Models\ClienteMensalista;
use Illuminate\Support\Facades\DB;

trait GenerateVoucher
{
    /**
     * Recupera uma vaga vazia
     *
     * @return App\Models\Vaga
     */
    public function getFreeVacancy($type)
    {
        $vacancy = Vaga::where('VAG_ST_SITUACAO', VagaEnum::LIVRE)
            ->where('VAG_FK_TIPO_CLIENTE', $type)
            ->first();
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

