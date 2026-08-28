@extends('layouts.app')

@section('title', 'Editar Filme - Administracao')

@section('content')
    <section class="section-header">
        <div>
            <p class="eyebrow">Edicao</p>
            <h1>Editar filme</h1>
            <p class="muted">Atualize as informacoes do catalogo.</p>
        </div>
        <a class="button button-secondary" href="{{ route('admin.movies.index') }}">Voltar</a>
    </section>

    @include('admin.movies.form', [
        'action' => route('admin.movies.update', $movie),
        'method' => 'PUT',
        'buttonText' => 'Atualizar filme',
    ])
@endsection
