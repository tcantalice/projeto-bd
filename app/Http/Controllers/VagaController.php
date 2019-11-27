<?php

namespace App\Http\Controllers;

use App\Models\Vaga;

class VagaController extends Controller
{
    public function __invoke()
    {
        $vagas = Vaga::all();
        return view('vaga.index', compact('vagas'));
    }
}
