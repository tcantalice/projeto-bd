@extends('layouts.system', ['context'=>'Voucher'])

@section('content')
<h1>Voucher: <strong>{{ $voucher->VCH_ID_VOUCHER }}</strong></h1>
<h2>Placa do veículo: <strong>{{ $voucher->VCH_FK_PLACA }}</strong></h2>
<h2>Cliente:
    <strong>{{ $voucher->VCH_FK_TIPO_CLIENTE == \App\Enums\TipoCliente::HORISTA ? 'Horista' : 'Mensalista' }}</strong>
</h2>
<h2>Nº Vaga: <strong>{{ $voucher->VCH_FK_VAGA }}</strong></h2>
<h2>Entrada às: <strong>{{ $voucher->VCH_HR_ENTRADA }}</strong></h2>
@endsection
