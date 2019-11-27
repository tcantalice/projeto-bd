<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClienteMensalista;

class ContratoController extends Controller
{
    public function create(ClienteMensalista $client)
    {
        $registration = $client->CLM_ID_MATRICULA;

    }
}
