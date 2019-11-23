<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente as TipoClienteEnum;
use App\Enums\Vaga as VagaEnum;
use App\Models\ClienteMensalista;
use App\Traits\GenerateVoucher as GenerateVoucherTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    use GenerateVoucherTrait;

    public function index()
    {
        return view('voucher.index');
    }

    public function mensalista(Request $request)
    {
        return view('voucher.mensalista', ['clientes' => array()]);
    }

    public function mensalistaSearch(Request $request)
    {
        $rules = [];
        if ($request->get('cpf') && !empty($request->cpf)) {
            $rules[] = ['CLM_DS_CPF', $request->cpf];
        }

        if ($request->get('matricula') && !empty($request->matricula)) {
            $rules[] = ['CLM_ID_MATRICULA', $request->matricula];
        }

        $results = ClienteMensalista::where($rules)->get();

        return view('voucher.mensalista', ['clientes' => $results]);
    }

    /**
     * Tela de geração de voucher para horistas
     *
     * @param Request $request
     */
    public function horista(Request $request)
    {
        $totalMensalista = count(ClienteMensalista::all());
        $totalVacancy = count(Vaga::where('VAG_ST_SITUACAO', VagaEnum::LIVRE)->get());

        if ($totalVacancy == $totalMensalista) {
            return redirect()->route('voucher')->withErrors(['noVacancy' => 'Não há vagas!']);
        }

        return view('voucher.horista');
    }

    /**
     * Redirecionar ao gerador de voucher do tipo de cliente
     *
     * @param Request $request
     * @param int $tipoCliente
     */
    public function generate(Request $request, $tipoCliente)
    {
        if ($tipoCliente == TipoClienteEnum::MENSALISTA) {
            $this->gen4Mensalista($request);
        } else if ($tipoCliente == TipoClienteEnum::HORISTA) {
            $this->gen4Horista($request);
        } else {
            return redirect()->back()->withErrors([
                'invalidType' => 'Tipo de cliente inválido'
            ]);
        }
    }

    private function gen4Mensalista(Request $request)
    {
        $data = $request->all();
        $client = ClienteMensalista::find($data['matricula']);
        $vehicle = $client->veiculos()->find($data['placaVeiculo']);
        try {
            DB::beginTransaction();
            $vacancy = $this->getFreeVacancy();
            $voucherCode = $this->voucherCode('M');

            $voucher = new Voucher();

            $voucher->VCH_ID_VOUCHER = $voucherCode;
            $voucher->VCH_FK_PLACA = $vehicle->VCL_ID_PLACA;
            $voucher->VCH_FK_TIPO_CLIENTE = TipoClienteEnum::MENSALISTA;
            $voucher->VCH_FK_VAGA = $vacancy->VAG_ID_VAGA;
            $voucher->VCH_HR_ENTRADA = Carbon::time()->format('H:i:s');

            $voucher->save();

            $vacancy->VAG_ST_STATUS = VagaEnum::OCUPADA;
            $vacancy->update();

            DB::commit();
        } catch(\Throwable $th) {
            DB::rollBack();
        }
    }

    private function gen4Horista(Request $request)
    {

    }

    public function show()
    {

    }
}
