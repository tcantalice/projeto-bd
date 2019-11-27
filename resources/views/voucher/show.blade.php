@extends('layouts.system', ['context'=>'Voucher'])

@section('content')
<div class="row">
    <div id="titulo" class="container mt-3 py-4 border-bottom border-dark">
        <h1>Voucher</h1>
    </div>
</div>
<div class="container">
    <div class="jumbotron container bg-warning shadow-lg mt-3 py-4">
        <h1>Voucher: <strong>{{ $voucher->VCH_ID_VOUCHER }}</strong></h1>
        <hr>
        <h3>Placa do veículo: <strong>{{ $voucher->VCH_FK_PLACA }}</strong></h3>
        <h3>Cliente:
            <strong>
                {{ resolveClientTypeAlias($voucher->VCH_FK_TIPO_CLIENTE) }}
            </strong>
        </h3>
        <hr>
        <h4>Nº Vaga: <strong>{{ $voucher->VCH_FK_VAGA }}</strong></h4>
        <h4>Entrada às: <strong>{{ $voucher->VCH_HR_ENTRADA }}</strong></h4>
    </div>
    <a class="btn btn-warning" href="{{ route('home') }}">Inicio</a>
</div>
@endsection
