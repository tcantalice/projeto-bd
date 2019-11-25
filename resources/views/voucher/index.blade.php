@extends('layouts.system', ['context' => 'Voucher'])

@section('content')
<h1>Tipo do cliente</h1>

<a href="{{ route('voucher.horista') }}">Horista</a>
<a href="{{ route('voucher.mensalista') }}">Mensalista</a>
@endsection
