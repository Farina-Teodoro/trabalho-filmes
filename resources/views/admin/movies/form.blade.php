<form class="form panel" action="{{ $action }}" method="POST">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="form-grid">
        <label>
            <span>Nome</span>
            <input type="text" name="nome" value="{{ old('nome', $movie->nome) }}" maxlength="150" required>
            @error('nome')
                <small>{{ $message }}</small>
            @enderror
        </label>

        <label>
            <span>Ano</span>
            <input type="number" name="ano" value="{{ old('ano', $movie->ano) }}" min="1888" max="{{ now()->year }}" required>
            @error('ano')
                <small>{{ $message }}</small>
            @enderror
        </label>
    </div>

    <label>
        <span>Categoria</span>
        <input type="text" name="categoria" value="{{ old('categoria', $movie->categoria) }}" maxlength="80" required>
        @error('categoria')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Imagem da capa (URL)</span>
        <input type="url" name="imagem_capa" value="{{ old('imagem_capa', $movie->imagem_capa) }}" placeholder="https://..." required>
        @error('imagem_capa')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Trailer no YouTube</span>
        <input type="url" name="link_trailer" value="{{ old('link_trailer', $movie->link_trailer) }}" placeholder="https://www.youtube.com/watch?v=..." required>
        @error('link_trailer')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <label>
        <span>Sinopse</span>
        <textarea name="sinopse" rows="6" required>{{ old('sinopse', $movie->sinopse) }}</textarea>
        @error('sinopse')
            <small>{{ $message }}</small>
        @enderror
    </label>

    <button class="button button-primary" type="submit">{{ $buttonText }}</button>
</form>
