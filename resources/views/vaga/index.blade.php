@extends('layouts.system', ['context' => 'Vaga'])

@section('content')
<div class="row">
    <div id="titulo" class="container mt-4 py-3 border-bottom border-dark">
        <h1>Vagas</h1>
    </div>
</div>
<div class="container pt-4">
    <form action="{{ route('vagas.search') }}" method="GET">
        @csrf
        <div class="form-row">
            <div class="form-group col-10">
                <input id="search-voucher" type="text" class="form-control" name="voucher" placeholder="Código do Voucher">
            </div>
            <div class="form-group col-2">
                <button type="submit" class="btn btn-warning btn-block"><strong>Buscar</strong></button>
            </div>
        </div>
    </form>
    <div class="card-deck d-flex flex-wrap">
        @forelse($vagas as $vaga)
        @php
            $voucher = $vaga->voucher();
        @endphp
        <div class="card flex-grow-1 my-3" style="min-width: 20%;">
            <div class="py-1 container card-header {{ isFree($vaga->VAG_ST_SITUACAO) ? 'bg-success' : 'bg-danger' }}">
               <div class="row justify-content-between align-content-end px-2">
                    <p class="mb-0"><strong>VAGA: {{ $vaga->VAG_ID_VAGA }}</strong></p>
                    <p class="mb-0"><strong>{{ resolveClientTypeAlias($vaga->VAG_FK_TIPO_CLIENTE) }}</strong></p>
               </div>
            </div>
            <div class="card-body px-3">
                @if(!is_null($voucher))
                <p class="mb-0">
                    <strong>Voucher: </strong>{{ $voucher->VCH_ID_VOUCHER }}<br>
                    <strong>Veículo: </strong>{{ $voucher->VCH_FK_PLACA }}<br>
                    <strong>Entrada: </strong>{{ $voucher->VCH_HR_ENTRADA }}
                </p>
                @else
                <h3 class="text-center my-3">LIVRE</h3>
                @endif
            </div>
            <a class="card-footer bg-warning btn btn-warning {{ is_null($voucher) ? 'disabled' : ''}}">
                Ver voucher
            </a>
        </div>
        @empty
        <h3 class="text-center ml-3">Nenhum resultado encontrado</h3>
        @endforelse
    </div>
</div>
@endsection
