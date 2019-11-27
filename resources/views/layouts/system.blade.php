<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <title>{{ config('app.name') }} - {{ $context }}</title>
</head>
<body>
    <div id="generalTop" class="container-fluid w-100 h-60">
        <img class="logo w-60 py-1" src="{{ asset('/images/logo.svg') }}">
    </div>
    <div class='content'>
        @yield('content')
    </div>
    <footer class="container border-top border-dark mt-3 py-5">
        <div class="row">
            <div class="col-6 col-md">
                <h4>About us</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted">Lorem</a></li>
                    <li><a href="#" class="text-muted">Ipsum</a></li>
                    <li><a href="#" class="text-muted">Dolor</a></li>
                    <li><a href="#" class="text-muted">Sit Amek</a></li>
                </ul>
            </div>
            <div class="col-6">
                <h4>Support</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted">Phone: 8957-8874-22</a></li>
                    <li><a href="#" class="text-muted">Adress: QuickSilver St. 22</a></li>
                    <li><a href="#" class="text-muted">E-mail: support@flanelaspark.com</a></li>
                </ul>
            </div>
            <div class="row align-self-end">
                <div id="copyright" class="col-12 col-md">
                    <p class="text-muted">Copyright &COPY; 2019. Flanela's Park All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- TODO scripts -->
    @section('scripts')
    <script src='{{ asset('/js/system.js') }}'></script>
    @show
</body>
</html>
