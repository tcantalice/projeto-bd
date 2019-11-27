<?php

use App\Enums\Vaga as VagaEnum;
use Illuminate\Support\Facades\DB;

if(!function_exists('resolveClientTypeAlias')) {
    /**
     * Resolve o alias do tipo de cliente
     *
     * @param int $id
     * @return string
     */
    function resolveClientTypeAlias($id) {
        $clientType = DB::table('TIPO_CLIENTE')
            ->where('TPC_ID_TIPO_CLIENTE', $id)
            ->first(['TPC_DS_ALIAS'])->TPC_DS_ALIAS;
        return $clientType;
    }
}

if(!function_exists('isFree')) {

    /**
     * Resolve se o status é livre
     *
     * @param $status
     * @return boolean
     */
    function isFree($status) {
        return ($status == VagaEnum::LIVRE);
    }
}
