@extends('layouts.app')

@section('title', 'Novo Filme - Administracao')

@section('content')
    <section class="section-header">
        <div>
            <p class="eyebrow">Cadastro</p>
            <h1>Novo filme</h1>
            <p class="muted">Preencha os dados principais do filme.</p>
        </div>
        <a class="button button-secondary" href="{{ route('admin.movies.index') }}">Voltar</a>
    </section>

    @include('admin.movies.form', [
        'action' => route('admin.movies.store'),
        'method' => 'POST',
        'buttonText' => 'Salvar filme',
    ])
@endsection
