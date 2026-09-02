<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Catalogo de Filmes')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ route('movies.index') }}">Catalogo de Filmes</a>

        <nav class="nav">
            <a href="{{ route('movies.index') }}">Catalogo</a>
            <a class="button button-secondary" href="{{ route('admin.movies.index') }}">Administração</a>
            <a class="button button-primary" href="{{ route('admin.movies.create') }}">Novo filme</a>
        </nav>
    </header>

    <main class="page">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
