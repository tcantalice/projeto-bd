@extends('layouts.system', ['context'=>'Voucher Horista'])

@section('content')
<div class="row">
    <div id="titulo" class="container mt-4 py-3 border-bottom border-dark">
        <h1>Voucher - Horista</h1>
    </div>
</div>
<div class="container py-4">
    <form action="{{ route('voucher.horista.generate') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="veiculo-placa" class="h4">Placa do carro</label>
            <input id="veiculo-placa" class="form-control veiculo-placa" name="placa" type="text">
            <small>Ex: AAA-0000</small>
        </div>
        <a href="{{ route('home') }}" class="btn btn-dark"><strong>Voltar</strong></a>
        <button class="btn btn-warning" type="submit"><strong>Gerar voucher</strong></button>
    </form>
</div>
@endsection
