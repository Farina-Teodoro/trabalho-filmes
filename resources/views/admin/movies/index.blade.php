@extends('layouts.app')

@section('title', 'Filmes - Administracao')

@section('content')
    <section class="section-header">
        <div>
            <p class="eyebrow">Painel</p>
            <h1>Filmes cadastrados</h1>
            <p class="muted">Cada filme fica vinculado ao usuario que fez a insercao.</p>
        </div>
        <a class="button button-primary" href="{{ route('admin.movies.create') }}">Cadastrar filme</a>
    </section>

    @if ($movies->isEmpty())
        <div class="empty-state">
            <h2>Nenhum filme cadastrado</h2>
            <p>Comece adicionando o primeiro item do catalogo.</p>
            <a class="button button-primary" href="{{ route('admin.movies.create') }}">Novo filme</a>
        </div>
    @else
        <div class="movie-grid">
            @foreach ($movies as $movie)
                <article class="movie-card">
                    <img src="{{ $movie->imagem_capa }}" alt="Capa de {{ $movie->nome }}">
                    <div class="movie-card-body">
                        <div class="movie-meta">
                            <span>{{ $movie->category?->nome ?? $movie->categoria }}</span>
                            <span>{{ $movie->ano }}</span>
                        </div>
                        <h2>{{ $movie->nome }}</h2>
                        <p>{{ Str::limit($movie->sinopse, 130) }}</p>
                        <p class="inserted-by">Inserido por {{ $movie->user?->name ?? 'Usuario removido' }}</p>
                        <div class="actions">
                            <a class="button button-secondary" href="{{ $movie->link_trailer }}" target="_blank" rel="noreferrer">Trailer</a>
                            <a class="button button-secondary" href="{{ route('admin.movies.edit', $movie) }}">Editar</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Excluir este filme?')">
                                @csrf
                                @method('DELETE')
                                <button class="button button-danger" type="submit">Excluir</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="pagination">
            {{ $movies->links() }}
        </div>
    @endif
@endsection
