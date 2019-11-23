<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $VCH_ID_VOUCHER
 * @property string $VCH_FK_PLACA
 * @property int $VCH_FK_TIPO_CLIENTE
 * @property int $VCH_FK_VAGA
 * @property string $VCH_HR_ENTRADA
 * @property string $VCH_HR_SAIDA
 * @property Veiculo $veiculo
 * @property Vaga $vaga
 */
class Voucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'VOUCHER';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'VCH_ID_VOUCHER';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'VCH_FK_PLACA',
        'VCH_FK_TIPO_CLIENTE',
        'VCH_FK_VAGA',
        'VCH_HR_ENTRADA',
        'VCH_HR_SAIDA'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'VCH_FK_PLACA', 'VCL_ID_PLACA');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vaga()
    {
        return $this->belongsTo(Vaga::class, 'VCH_FK_VAGA', 'VAG_ID_VAGA');
    }

}
