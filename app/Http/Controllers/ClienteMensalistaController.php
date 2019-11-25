<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClienteMensalista;
use Illuminate\Support\Facades\Validator;

class ClienteMensalistaController extends Controller
{
    /**
     * Busca por clientes mensalistas
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     */
    public function search(Request $request)
    {
        $rules = [];
        if ($request->get('cpf') && !empty($request->cpf)) {
            $rules[] = ['CLM_DS_CPF', $request->cpf];
        }

        if ($request->get('matricula') && !empty($request->matricula)) {
            $rules[] = ['CLM_ID_MATRICULA', $request->matricula];
        }

        $results = ClienteMensalista::where($rules)->get();

        return back()->with(['clientes' => $results]);
    }

    public function delete(Request $request)
    {
        return view('cliente_mensalista.delete');
    }

    public function destroy(Request $request, $matricula)
    {

    }

    public function create()
    {
        return view('cliente_mensalista.index');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['matricula'] = $this->generateRegistration();
        $entity = ClienteMensalista::createInstance($data);

        $validator = self::validate($entity);

        if ($validator->fails()) {
            $request->flash();
            return view('cliente_mensalista.create')
                ->withErrors($validator, 'create');
        }

        $success = $entity->save();

        /* $inputs = [
            'CLM_ID_MATRICULA' => $request->get('matricula'),
            'CLM_DS_CPF' => $request->get('cpf'),
            'CLM_DS_NOME' => $request->get('nome'),
            'CLM_DT_NASCIMENTO' => $request->get('nascimento')
        ];

        ClienteMensalista::insert($inputs); */

        return view('cliente_mensalista.create', compact('success'));
    }

    public function edit(Request $request)
    {
        return "cliente_mensalista.edit";
    }

    public function update(Request $request, $matricula)
    {
        $clienteMensalista = ClienteMensalista::find($matricula);
    }

    /**
     * Gera um novo número de matrícula
     *
     * @return void
     */
    private static function generateRegistration()
    {

    }

    /**
     * Valida os dados da entidade
     *
     * @param ClienteMensalista $entity
     * @return void
     */
    private static function validate($entity)
    {
        $messages = [
            'required' => 'O campo é obrigatório',
            'size' => 'Quantidade de caracteres inválida',
            'unique' => 'Este valor já está presente no banco'
        ];

        $rules = [
            'CLM_DS_CPF' => 'required|size:11|unique:CLIENTE_MENSALISTA,CLM_DS_CPF',
            'CLM_DS_NOME' => 'required',
            'CLM_DT_NASCIMENTO' => 'required'
        ];

        return Validator::make($entity, $rules, $messages);
    }
}
