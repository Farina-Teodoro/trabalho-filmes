<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::with(['user', 'category', 'detail'])
            ->latest()
            ->paginate(8);

        return view('admin.movies.index', compact('movies'));
    }

    public function create(): View
    {
        return view('admin.movies.create', [
            'movie' => new Movie,
            'categories' => Category::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $this->movieOwner($request)->id;
        $category = $this->resolveCategory($data);
        $data['category_id'] = $category->id;
        $data['categoria'] = $category->nome;

        Movie::create($data);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Filme cadastrado com sucesso.');
    }

    public function edit(Movie $movie): View
    {
        return view('admin.movies.edit', [
            'movie' => $movie,
            'categories' => Category::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $data = $this->validatedData($request);
        $category = $this->resolveCategory($data);
        $data['category_id'] = $category->id;
        $data['categoria'] = $category->nome;

        $movie->update($data);

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
            'ano' => ['required', 'integer', 'min:1888', 'max:'.now()->year],
            'category_id' => ['nullable', 'integer', 'exists:categories,id', 'required_without:categoria'],
            'categoria' => ['nullable', 'string', 'max:80', 'required_without:category_id'],
            'imagem_capa' => ['required', 'url', 'max:500'],
            'link_trailer' => ['required', 'url', 'max:500'],
        ]);
    }

    /**
     * Keeps the foreign key as the source of truth. The text fallback also makes
     * the endpoint convenient for simple API/form submissions and older data.
     */
    private function resolveCategory(array $data): Category
    {
        if (! empty($data['category_id'])) {
            return Category::findOrFail($data['category_id']);
        }

        $name = trim($data['categoria']);

        return Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['nome' => $name],
        );
    }

    /**
     * O painel é público para a apresentação do trabalho, mas a coluna user_id
     * continua sempre preenchida, como pede a modelagem do banco.
     */
    private function movieOwner(Request $request): User
    {
        if ($request->user()) {
            return $request->user();
        }

        return User::firstOrCreate(
            ['email' => 'admin@filmes.test'],
            ['name' => 'Administrador', 'password' => 'senha123'],
        );
    }
}
