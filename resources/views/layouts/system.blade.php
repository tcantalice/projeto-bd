<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ config('app.name') }} - {{ $context }}</title>
</head>
<body>
    <div class='content'>
        @yield('content')
    </div>
    <!-- TODO scripts -->
    @section('scripts')
    <script src='{{ asset('js/system.js') }}'></script>
    @show
</body>
</html>
