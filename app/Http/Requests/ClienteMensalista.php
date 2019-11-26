<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteMensalista extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => 'required|size:11|unique:CLIENTE_MENSALISTA,CLM_DS_CPF',
            'nome' => 'required',
            'dataNascimento' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cpf.size' => 'Tamanho máximo permitido é :size',
            'required'  => 'O campo é obrigatório',
            'cpf.unique' => 'Já existe um registro com esse CPF'
        ];
    }
}
