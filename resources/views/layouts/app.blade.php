<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <!-- Se l'utente è un admin -->
        @auth
            @if(Auth::user()->role === 'admin')  <!-- Verifica se l'utente è admin -->
                <!-- Pannello di amministrazione -->
                <div class="admin-sidebar">
                    <nav>
                        <ul>
                            <li><a href="{{ route('admin.projects.index') }}">Gestione Progetti</a></li>
                            <li><a href="{{ route('admin.types.index') }}">Gestione Tipologie</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="admin-content">
                    <header>
                        <h1>Pannello Amministrativo</h1>
                    </header>

                    <div class="container mt-4">
                        @yield('content')
                    </div>
                </div>

            @else
                <!-- L'utente non è un admin, quindi mostra il contenuto pubblico -->
                @include('layouts.partials.header')

                <div class="container mt-4">
                    @yield('content')
                </div>
            @endif
        @else
            <!-- L'utente non è autenticato, quindi mostra il contenuto pubblico -->
            @include('layouts.partials.header')

            <div class="container mt-4">
                @yield('content')
            </div>
        @endauth
    </div>
</body>
</html>
