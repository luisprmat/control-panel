<!doctype html>
<html lang="es" class="h-100">
    {{-- Header --}}
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') - Curso Styde</title>

        <!-- Dependencies from Laravel Mix CSS (Bootstrap 4, Fontawesome 5, ... etc)-->
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Custom styles for this template -->
        <link type="text/css" href="{{ asset('css/style.css') }}" rel="stylesheet" >
    </head>

    <body class="d-flex flex-column h-100">
        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{ url('/') }}">Curso-Styde</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('/usuarios') }}">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/profesiones') }}">Profesiones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/habilidades') }}">Habilidades</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ url('/usuarios/papelera') }}">Papelera</a>
                        </li>
                    </ul>

                    {{-- <form class="form-inline mt-2 mt-md-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form> --}}
                </div>
            </nav>
        </header>

        <!-- Begin page content -->
        <main role="main" class="flex-shrink-0" id="app">
            <div class="container">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="footer mt-auto py-3">
            <div class="container">
                <span class="text-muted">Pie de página de Curso-Styde</span>
            </div>
        </footer>
        <script src="{{ mix('js/app.js')}}"></script>
    </body>
</html>
