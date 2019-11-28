<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $BLC_ID_NUMERO
 * @property float $BLC_VL_VALOR
 * @property string $BLC_DT_VENCIMENTO
 * @property int $BLC_FK_NUMERO_CONTRATO
 * @property CONTRATO $cONTRATO
 */
class BoletoContrato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'BOLETO_CONTRATO';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'BLC_ID_NUMERO';

    /**
     * @var array
     */
    protected $fillable = ['BLC_VL_VALOR', 'BLC_DT_VENCIMENTO', 'BLC_FK_NUMERO_CONTRATO'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cONTRATO()
    {
        return $this->belongsTo('App\Models\CONTRATO', 'BLC_FK_NUMERO_CONTRATO', 'CNT_ID_NUMERO');
    }
}
