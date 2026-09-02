@extends('layouts.app')

@section('title', $movie->nome . ' - Catalogo de Filmes')

@section('content')
    <section class="movie-detail">
        <div class="poster-panel">
            <img src="{{ $movie->imagem_capa }}" alt="Capa de {{ $movie->nome }}">
        </div>

        <div class="detail-content">
            <p class="eyebrow">{{ $movie->category?->nome ?? $movie->categoria }} / {{ $movie->ano }}</p>
            <h1>{{ $movie->nome }}</h1>
            <p class="lead">{{ $movie->sinopse }}</p>

            <dl class="detail-list">
                @if ($movie->detail?->diretor)
                    <div>
                        <dt>Direcao</dt>
                        <dd>{{ $movie->detail->diretor }}</dd>
                    </div>
                @endif

                @if ($movie->detail?->duracao_minutos)
                    <div>
                        <dt>Duracao</dt>
                        <dd>{{ $movie->detail->duracao_minutos }} min</dd>
                    </div>
                @endif

                @if ($movie->detail?->classificacao)
                    <div>
                        <dt>Classificacao</dt>
                        <dd>{{ $movie->detail->classificacao }}</dd>
                    </div>
                @endif

                @if ($movie->user)
                    <div>
                        <dt>Cadastrado por</dt>
                        <dd>{{ $movie->user->name }}</dd>
                    </div>
                @endif
            </dl>

            @if ($movie->detail?->observacoes)
                <p class="muted">{{ $movie->detail->observacoes }}</p>
            @endif

            <div class="actions">
                <a class="button button-primary" href="{{ $movie->link_trailer }}" target="_blank" rel="noreferrer">Ver trailer</a>
                <a class="button button-secondary" href="{{ route('movies.index') }}">Voltar</a>
            </div>
        </div>
    </section>
@endsection
