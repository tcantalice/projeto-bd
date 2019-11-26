<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClienteMensalista;
use App\Http\Requests\ClienteMensalista as ClienteMensalistaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ClienteMensalistaController extends Controller
{
    /**
     * Página inicial - Clientes Mensalista
     */
    public function index()
    {
        $clientes = ClienteMensalisa::all();
        return view('cliente_mensalista.index', compact('clientes'));
    }

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

        $clients = ClienteMensalista::where($rules)->get();

        return back()->with(compact('clients'));
    }

    /**
     * Apaga o registro um cliente
     * @author Brendo Pinheiro
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @param $matricula
     * @return void
     */
    public function destroy(Request $request, $matricula)
    {
        $success = false;

        if ($client = ClienteMensalista::find($matricula)) {
            try {

                $vehicles = $client->veiculos;
                DB::beginTransaction();
                $client->contrato()->delete();

                foreach ($vehicles as $vehicle) {
                    $vehicle->delete();
                }

                $client->delete();

                DB::commit();
                $success = true;
            } catch(\Throwable $th) {
                DB::rollback();
                Log::error(self::class . "@destroy # ERRO: {$th}");
                return redirect()->route('mensalista')->withErrors(['Ocorreu um erro durante a operação. Tente novamente!']);
            }
        }
        return view('cliente_mensalista.index', compact('success'));
    }

    public function create()
    {
        return view('cliente_mensalista.index');
    }

    /**
     * Salva o registro de um cliente
     * @author Brendo Pinheiro
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @return void
     */
    public function store(ClienteMensalistaRequest $request)
    {
        $data = $request->except('_token');
        $data['matricula'] = $this->generateRegistration();

        $validator = $request->validated();

        if ($validator->fails()) {
            $request->flash();
            return view('cliente_mensalista.create')
            ->withErrors($validator, 'create');
        }

        $entity = ClienteMensalista::createInstance($data);

        $entity->CLM_ID_MATRICULA = $this->generateRegistration();

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

    /**
     * Tela de edição do cliente mensalista
     *
     * @param Request $request
     */
    public function edit(Request $request)
    {
        return "cliente_mensalista.edit";
    }

    /**
     * Atualiza o registro de um cliente
     * @author Brendo Pinheiro
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @return void
     */
    public function update(ClienteMensalistaRequest $request, $matricula)
    {
        $success = false;
        if ($clienteMensalista = ClienteMensalista::find($matricula)) {
            $validator = $request->validated();

            if ($validator->fails()) {
                $request->flash();
                return view('cliente_mensalista.edit')
                    ->withErrors($validator, 'edit');
            }

            $clienteMensalista = ClienteMensalista::createInstance($request-all(), $clienteMensalista);

            $success = $clienteMensalista->update();
        }

        return view('cliente_mensalista.edit', compact('success'));
    }

    /**
     * Gera um novo número de matrícula
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @return string
     */
    private function generateRegistration()
    {
        $cacheYear = Cache::get('year_code', 0);
        $currentYear = Carbon::now('America/Bahia')->year;

        $lastCode = Cache::get('last_code', 0);

        if ($cacheYear < $currentYear) {
            $cacheYear = $currentYear;
            Cache::put('year_code', $cacheYear, 3600000);
            $lastCode = 1;
            Cache::put('last_code', $lastCode, 3600000);
        }

        $code = $cacheYear . str_pad($lastCode, 4, '0', STR_PAD_LEFT);
        Cache::increment('last_code', 1);
        return $code;
    }

}
