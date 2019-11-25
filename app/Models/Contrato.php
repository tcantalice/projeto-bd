<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CNT_ID_NUMERO
 * @property int $CNT_FK_CLIENTE
 * @property string $CNT_DT_CRIACAO
 * @property string $CNT_DT_RENOVACAO
 * @property int $CNT_ST_SITUACAO
 * @property ClienteMensalista $cliente
 */
class Contrato extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CONTRATO';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'CNT_ID_NUMERO';

    /**
     * @var array
     */
    protected $fillable = [
        'CNT_FK_CLIENTE',
        'CNT_DT_CRIACAO',
        'CNT_DT_RENOVACAO',
        'CNT_ST_SITUACAO'
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
    public function cliente()
    {
        return $this->belongsTo(ClienteMensalista::clas, 'CNT_FK_CLIENTE', 'CLM_ID_MATRICULA');
    }
}
