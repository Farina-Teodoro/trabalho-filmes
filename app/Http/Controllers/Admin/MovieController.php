<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::with('user')
            ->latest()
            ->paginate(8);

        return view('admin.movies.index', compact('movies'));
    }

    public function create(): View
    {
        return view('admin.movies.create', [
            'movie' => new Movie(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()->id;

        Movie::create($data);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Filme cadastrado com sucesso.');
    }

    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $movie->update($this->validatedData($request));

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Filme atualizado com sucesso.');
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Filme excluido com sucesso.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:150'],
            'sinopse' => ['required', 'string'],
            'ano' => ['required', 'integer', 'min:1888', 'max:' . now()->year],
            'categoria' => ['required', 'string', 'max:80'],
            'imagem_capa' => ['required', 'url', 'max:500'],
            'link_trailer' => ['required', 'url', 'max:500'],
        ]);
    }
}
