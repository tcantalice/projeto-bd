<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CLM_ID_MATRICULA
 * @property string $CLM_DS_CPF
 * @property string $CLM_DS_NOME
 * @property string $CLM_DT_NASCIMENTO
 */
class ClienteMensalista extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CLIENTE_MENSALISTA';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'CLM_ID_MATRICULA';

    /**
     * @var array
     */
    protected $fillable = [
        'CLM_DS_CPF',
        'CLM_DS_NOME',
        'CLM_DT_NASCIMENTO'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class, 'VCL_FK_PROPRIETARIO', 'CLM_ID_MATRICULA');
    }
}
