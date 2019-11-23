@extends('layouts.system', ['context' => 'Voucher'])

@section('content')
<h1>Tipo do cliente</h1>

<a class="btn btn-primary" href="{{ route('voucher.mensalista') }}">Horista</a>
<a class="btn btn-success" href="{{ route('voucher.horista') }}">Mensalista</a>
@endsection
