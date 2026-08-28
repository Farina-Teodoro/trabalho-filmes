@extends('layouts.app')

@section('title', 'Entrar - Catalogo de Filmes')

@section('content')
    <section class="auth-panel">
        <div>
            <p class="eyebrow">Administracao</p>
            <h1>Entrar no painel</h1>
            <p class="muted">Use a conta criada pelo seeder para cadastrar e gerenciar os filmes.</p>
        </div>

        <form class="form" action="{{ route('login.store') }}" method="POST">
            @csrf

            <label>
                <span>E-mail</span>
                <input type="email" name="email" value="{{ old('email', 'admin@filmes.test') }}" required autofocus>
                @error('email')
                    <small>{{ $message }}</small>
                @enderror
            </label>

            <label>
                <span>Senha</span>
                <input type="password" name="password" value="senha123" required>
                @error('password')
                    <small>{{ $message }}</small>
                @enderror
            </label>

            <label class="check">
                <input type="checkbox" name="remember" value="1">
                <span>Lembrar acesso</span>
            </label>

            <button class="button button-primary full" type="submit">Entrar</button>
        </form>
    </section>
@endsection
