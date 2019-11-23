<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $VCL_ID_PLACA
 * @property int $VCL_FK_PROPRIETARIO
 * @property string $VCL_DS_MODELO
 * @property string $VCL_DS_COR
 * @property ClienteMensalista $proprietario
 */
class Veiculo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'VEICULO';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'VCL_ID_PLACA';

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
        'VCL_FK_PROPRIETARIO',
        'VCL_DS_MODELO',
        'VCL_DS_COR'
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
    public function proprietario()
    {
        return $this->belongsTo(ClienteMensalista::class, 'VCL_FK_PROPRIETARIO', 'CLM_ID_MATRICULA');
    }
}
