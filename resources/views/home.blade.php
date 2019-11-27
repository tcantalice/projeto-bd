@extends('layouts.system', ['context' => 'Home'])

@section('content')
<div class="row">
    <div id="titulo" class="container mt-4 py-3 border-bottom border-dark">
        <h1>Gerar voucher</h1>
    </div>
</div>
<div class="container">
    <div id="row1" class="row">
        <div id="botao" class="col-12 py-5 mt-3">
            <a href="{{ route('voucher.mensalista') }}" id="mensalista" class="btn btn-block btn-lg btn-warning p-5"><strong>Mensalista</strong></a>
            <a href="{{ route('voucher.horista') }}" id="horista" class="btn btn-block btn-lg btn-warning  p-5"><strong>Horista</strong></a>
        </div>
    </div>
</div>
<div class="row">
    <div id="titulo" class="container mt-4 py-3 border-bottom border-dark">
        <h1>Visualizar</h1>
    </div>
</div>
<div class="container">
    <div id="row1" class="row">
        <div id="botao" class="col-12 py-5 mt-3">
            <a href="{{ route('vagas') }}" id="mensalista" class="btn btn-block btn-lg btn-warning px-5"><strong>Vagas</strong></a>
        </div>
    </div>
</div>
@endsection
