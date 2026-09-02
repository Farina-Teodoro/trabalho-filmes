<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $selectedYear = $request->integer('ano') ?: null;
        $selectedCategory = $request->query('categoria');

        $movies = Movie::query()
            ->with(['category', 'detail'])
            ->when($selectedYear, fn ($query) => $query->where('ano', $selectedYear))
            ->when($selectedCategory, function ($query, string $slug) {
                $query->whereHas('category', fn ($category) => $category->where('slug', $slug));
            })
            ->orderByDesc('ano')
            ->orderBy('nome')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->has('movies')
            ->orderBy('nome')
            ->get();

        $years = Movie::query()
            ->select('ano')
            ->distinct()
            ->orderByDesc('ano')
            ->pluck('ano');

        return view('movies.index', compact('movies', 'categories', 'years', 'selectedYear', 'selectedCategory'));
    }

    public function show(Movie $movie): View
    {
        $movie->load(['category', 'detail', 'user']);

        return view('movies.show', compact('movie'));
    }
}
