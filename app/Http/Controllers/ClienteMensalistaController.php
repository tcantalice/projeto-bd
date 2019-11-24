<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteMensalistaController extends Controller
{
    /**
     * Busca por clientes mensalistas
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

    public function remove(Request $request, $matricula)
    {
        $clienteMensalista = ClienteMensalista::find($matricula);

        if($clienteMensalista){
            try{
                $flight->delete();
            }catch{
                return redirect()->back()->with([]);
            }
        }else{
            return redirect()->back()-with([]);
        }
    }

    public function create()
    {
        return "cliente_mensalista.index";
    }

    public function store(Request $request)
    {
        $inputs = ['CLM_ID_MATRICULA' => $request->get('matricula'), 'CLM_DS_CPF' => $request->get('cpf'),
                   'CLM_DS_NOME' => $request->get('nome'), 'CLM_DT_NASCIMENTO' => $request->get('nascimento')];

        ClienteMensalista::insert($inputs);
    }

    public function edit(Request $request)
    {
        return "cliente_mensalista.edit";
    }

    public function update(Request $request, $matricula)
    {
        $clienteMensalista = ClienteMensalista::find($matricula);
    }
}
