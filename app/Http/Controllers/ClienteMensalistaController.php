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

        return redirect()->back()->with(['clientes' => $results]);
    }
}
