@extends('layouts.system', ['context'=>'Voucher Mensalista'])

@section('content')
<div class="row mb-3">
    <div id="titulo" class="container mt-4 py-3 border-bottom border-dark">
        <h1>Voucher - Mensalista</h1>
    </div>
</div>
<div class="container py-4">
    <form action="{{ route('voucher.mensalista.generate') }}" method="POST">
        @csrf
        @method('POST')
        @error('404')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @enderror
        <div class="form-group">
            <label for="matricula" class="h4">Matrícula do cliente</label>
            <input id="matricula" class="form-control matricula" name="matricula" type="text">
            <small>Ex: 20010011</small>
        </div>
        <a href="{{ route('home') }}" class="btn btn-dark"><strong>Voltar</strong></a>
        <button class="btn btn-warning" type="submit"><strong>Gerar voucher</strong></button>
    </form>
</div>
@endsection
