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

    /**
     * Gera o voucher para cliente do tipo mensalista
     *
     * @param Request $request
     * @return void
     */
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
        $data = $request->all();
        $vehicleSign = $data['placa'];
        try {
            DB::beginTransaction();

            $vacancy = $this->getFreeVacancy();
            $voucherCode = $this->voucherCode('H');

            $voucher = new Voucher();

            $voucher->VCH_ID_VOUCHER = $voucherCode;
            $voucher->VCH_FK_PLACA = $vehicleSign;
            $voucher->VCH_FK_TIPO_CLIENTE = TipoClienteEnum::HORISTA;
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

    public function show(Request $request, $voucher)
    {
        $voucher = Voucher::find($voucher);

        $view = view('voucher.show');

        if ($voucher) {
            $view = $view->with(compact('voucher'));
        }

        return $view;
    }

    public function close(Request $request, $voucher)
    {
        $voucher = Voucher::find($voucher);

        if($voucher) {
            $data = [];

            $vacancy = $voucher->vaga;
            $voucher->VCH_HR_SAIDA = Carbon::time()->format('H:i:S');
            $typeClient = $voucher->VCH_FK_TIPO_CLIENTE;

            if ($typeClient == TipoClienteEnum::HORISTA) {
                $hourPrice = DB::table('VALOR')
                    ->select('VAL_VL_VALOR')
                    ->where('VAL_FK_TIPO_CLIENTE', TipoClienteEnum::HORISTA)
                    ->first();
                // Hora de entrada e saída
                $in = Carbon::createFromFormat("H:i:s", $voucher->VCH_HR_ENTRADA, 'America/Bahia');
                $out = Carbon::createFromFormat("H:i:s", $voucher->VCH_HR_SAIDA, 'America/Bahia');

                $totalHours = $in->diffInHours($out);
                $totalPrice = $totalHours * $hourPrice;
            }


        }
    }
}
