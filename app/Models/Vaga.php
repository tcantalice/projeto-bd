<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $VAG_ID_VAGA
 * @property int $VAG_ST_SITUACAO
 * @property int $VAG_FK_TIPO_CLIENTE
 */
class Vaga extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'VAGA';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'VAG_ID_VAGA';

    /**
     * @var array
     */
    protected $fillable = [
        'VAG_ST_SITUACAO',
        'VAG_FK_TIPO_CLIENTE'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return Voucher
     */
    public function voucher()
    {
        $voucher = Voucher::where('VCH_FK_VAGA', $this->VAG_ID_VAGA)
            ->whereNull('VCH_HR_SAIDA')
            ->first();
        return $voucher;
    }
}
