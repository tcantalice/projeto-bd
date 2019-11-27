<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CLM_ID_MATRICULA
 * @property string $CLM_DS_CPF
 * @property string $CLM_DS_NOME
 * @property string $CLM_DT_NASCIMENTO
 * @property Veiculo[] $veiculos
 * @property Contrato $contrato
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
     * Atributos da model
     */
    private const attributes = [
        'matricula' => 'CLM_ID_MATRICULA',
        'cpf' => 'CLM_DS_CPF',
        'nome' => 'CLM_DS_NOME',
        'dataNascimento' => 'CLM_DT_NASCIMENTO'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class, 'VCL_FK_PROPRIETARIO', 'CLM_ID_MATRICULA');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contrato()
    {
        return $this->hasOne(Contrato::class, 'CNT_FK_CLIENTE', 'CLM_ID_MATRICULA');
    }

    /**
     * Função responsável por criar uma instância de ClienteMensalista
     *
     * @param array $data
     * @param ClienteMensalista $entity
     * @return ClienteMensalista
     */
    public static function createInstance(array $data, ClienteMensalista $entity=null)
    {
        if(!$entity) $entity = new ClienteMensalista();
        foreach(self::attributes as $key => $attribute) {
            if(in_array($key, $data)) {
                $entity->attributes[$attribute] = $data[$key];
            }
        }
        return $entity;
    }
}
