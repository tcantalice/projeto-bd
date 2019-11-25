@extends('layouts.system', ['context'=>'Voucher Horista'])

@section('content')
@error('gerar_voucher')
    <h1>{{ $message }}</h1>
@enderror
<form action="{{ route('voucher.horista.generate') }}" method="POST">
    @csrf
    @method('POST')
    <input id="veiculo-placa" class="veiculo-placa" name="placa" type="text">
    <button type="submit">Gerar voucher</button>
</form>
@endsection
