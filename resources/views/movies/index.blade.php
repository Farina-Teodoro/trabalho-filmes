@extends('layouts.app')

@section('title', 'Catalogo de Filmes')

@section('content')
    <section class="section-header catalog-header">
        <div>
            <p class="eyebrow">Catalogo</p>
            <h1>Filmes para explorar</h1>
            <p class="muted">Escolha por ano ou categoria e abra qualquer filme para ver a sinopse completa.</p>
        </div>
    </section>

    <form class="filter-bar" action="{{ route('movies.index') }}" method="GET">
        <label>
            <span>Ano</span>
            <select name="ano">
                <option value="">Todos</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" @selected((int) $selectedYear === (int) $year)>{{ $year }}</option>
                @endforeach
            </select>
        </label>

        <label>
            <span>Categoria</span>
            <select name="categoria">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>
                        {{ $category->nome }}
                    </option>
                @endforeach
            </select>
        </label>

        <div class="filter-actions">
            <button class="button button-primary" type="submit">Filtrar</button>
            <a class="button button-secondary" href="{{ route('movies.index') }}">Limpar</a>
        </div>
    </form>

    @if ($movies->isEmpty())
        <div class="empty-state">
            <h2>Nenhum filme encontrado</h2>
            <p>Ajuste os filtros para ver outros resultados.</p>
        </div>
    @else
        <div class="movie-grid gallery-grid">
            @foreach ($movies as $movie)
                <a class="movie-card movie-card-link" href="{{ route('movies.show', $movie) }}">
                    <img src="{{ $movie->imagem_capa }}" alt="Capa de {{ $movie->nome }}">
                    <div class="movie-card-body">
                        <div class="movie-meta">
                            <span>{{ $movie->category?->nome ?? $movie->categoria }}</span>
                            <span>{{ $movie->ano }}</span>
                        </div>
                        <h2>{{ $movie->nome }}</h2>
                        <p>{{ Str::limit($movie->sinopse, 120) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $movies->links() }}
        </div>
    @endif
@endsection
