<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente as TipoClienteEnum;
use App\Enums\Vaga as VagaEnum;
use App\Models\ClienteMensalista;
use App\Models\Vaga;
use App\Models\Voucher;
use App\Traits\GenerateVoucher as GenerateVoucherTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucherController extends Controller
{
    use GenerateVoucherTrait;

    /**
     * Visão de geração de voucher para horistas
     * @author Tarcisio 'Kbça' Cantalice
     */
    public function mensalista(Request $request)
    {
        return view('voucher.mensalista', ['clientes' => array()]);
    }

    /**
     * Visão de geração de voucher para horistas
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     */
    public function horista(Request $request)
    {
        $totalMensalista = count(ClienteMensalista::all());
        $totalVacancy = count(Vaga::where('VAG_ST_SITUACAO', VagaEnum::LIVRE)->get());

        if ($totalVacancy == $totalMensalista) {
            return redirect()->route('voucher')->withErrors(['erro_vagas' => 'Não há vagas!']);
        }

        return view('voucher.horista');
    }

    /**
     * Mostra informações do voucher
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @param string $voucher
     */
    public function show(Request $request, $voucherId)
    {
        $view = view('voucher.show');

        if ($voucher = Voucher::find($voucherId)) {
            $view = $view->with(compact('voucher'));
        }

        return $view;
    }

    /**
     * Encerra o voucher
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @param string $voucher
     */
    public function close(Request $request, $voucher)
    {
        $voucher = Voucher::find($voucher);

        if($voucher) {
            $data = [];
            $vacancy = $voucher->vaga;

            $voucher->VCH_HR_SAIDA = Carbon::time()->format('H:i:S');
            $vacancy->VAG_ST_SITUACAO = VagaEnum::LIVRE;

            if($voucher->save()) {
                $vacancy->save();

                $data['voucher'] = $voucher;
            }

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
                $data['precoTotal'] = $totalHours * $hourPrice;
            }

            return view('voucher.show', $data);
        }

        return back(404)->withErrors(['erro_voucher' => 'Voucher não encontrado.']);
    }

    /**
     * Undocumented function
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @return void
     */
    public function gen4Horista(Request $request)
    {
        $data = $request->all();
        $vehicleSign = str_replace('-', '', $data['placa']);
        try {
            DB::beginTransaction();

            $vacancy = $this->getFreeVacancy(TipoClienteEnum::HORISTA);
            $voucherCode = $this->voucherCode('H');

            $voucher = new Voucher();

            $voucher->VCH_ID_VOUCHER = $voucherCode;
            $voucher->VCH_FK_PLACA = $vehicleSign;
            $voucher->VCH_FK_TIPO_CLIENTE = TipoClienteEnum::HORISTA;
            $voucher->VCH_FK_VAGA = $vacancy->VAG_ID_VAGA;
            $voucher->VCH_HR_ENTRADA = Carbon::now()->format('H:i:s');

            $voucher->save();

            $vacancy->VAG_ST_SITUACAO = VagaEnum::OCUPADA;
            $vacancy->update();

            DB::commit();
            return view('voucher.show', compact('voucher'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("ERRO#gen4Horista: {$th}");
            return view('voucher.horista')->withErrors(['Ocorreu um erro durante a geração do voucher. Tente novamente!'], 'gerar_voucher');
        }
    }

    /**
     * Gera o voucher para cliente do tipo mensalista
     * @author Tarcisio 'Kbça' Cantalice
     *
     * @param Request $request
     * @return void
     */
    public function gen4Mensalista(Request $request)
    {
        $data = $request->all();
        $client = ClienteMensalista::find($data['matricula']);
        $vehicle = $client->veiculos()->find($data['placaVeiculo']);
        try {
            DB::beginTransaction();
            $vacancy = $this->getFreeVacancy(TipoClienteEnum::MENSALISTA);
            $voucherCode = $this->voucherCode('M');

            $voucher = new Voucher();

            $voucher->VCH_ID_VOUCHER = $voucherCode;
            $voucher->VCH_FK_PLACA = $vehicle->VCL_ID_PLACA;
            $voucher->VCH_FK_TIPO_CLIENTE = TipoClienteEnum::MENSALISTA;
            $voucher->VCH_FK_VAGA = $vacancy->VAG_ID_VAGA;
            $voucher->VCH_HR_ENTRADA = Carbon::now()->format('H:i:s');

            $voucher->save();

            $vacancy->VAG_ST_SITUACAO = VagaEnum::OCUPADA;
            $vacancy->update();

            DB::commit();
            return view('voucher.show', compact('voucher'));
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("ERRO#gen4Mensalista: {$th}");
            return view('voucher.mensalista')->withErrors(['Ocorreu um erro durante a geração do voucher. Tente novamente!'], 'gerar_voucher');
        }
    }
}
