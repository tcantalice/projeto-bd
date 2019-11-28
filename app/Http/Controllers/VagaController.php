<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VagaController extends Controller
{
    public function index()
    {
        $vagas = Vaga::all();
        return view('vaga.index', compact('vagas'));
    }

    public function search(Request $request)
    {
        if ($request->has('voucher') && $request->voucher) {
            $voucherId = $request->voucher;
            $vouchers = Voucher::where('VCH_ID_VOUCHER', 'like', "%{$voucherId}%")->get();
            $vagas = array();
            if(!empty($vouchers)) {
                foreach($vouchers as $voucher) {
                    $vagas[] = $voucher->vaga;
                }
            }

            return view('vaga.index', compact('vagas'));
        }
        return redirect()->route('vagas');
    }
}
