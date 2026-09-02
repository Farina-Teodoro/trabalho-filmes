<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_filters_movies_by_year_and_category(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $drama = Category::create(['nome' => 'Drama', 'slug' => 'drama']);
        $action = Category::create(['nome' => 'Acao', 'slug' => 'acao']);

        $matchedMovie = Movie::create([
            'user_id' => $user->id,
            'category_id' => $drama->id,
            'nome' => 'Filme Encontrado',
            'sinopse' => 'Sinopse do filme encontrado.',
            'ano' => 2020,
            'categoria' => 'Drama',
            'imagem_capa' => 'https://example.com/capa.jpg',
            'link_trailer' => 'https://example.com/trailer',
        ]);

        $matchedMovie->detail()->create([
            'diretor' => 'Diretor Teste',
            'duracao_minutos' => 100,
            'classificacao' => '12 anos',
        ]);

        Movie::create([
            'user_id' => $user->id,
            'category_id' => $action->id,
            'nome' => 'Filme Fora',
            'sinopse' => 'Sinopse do filme fora do filtro.',
            'ano' => 2021,
            'categoria' => 'Acao',
            'imagem_capa' => 'https://example.com/outra-capa.jpg',
            'link_trailer' => 'https://example.com/outro-trailer',
        ]);

        $response = $this->get(route('movies.index', [
            'ano' => 2020,
            'categoria' => 'drama',
        ]));

        $response
            ->assertOk()
            ->assertSee('Filme Encontrado')
            ->assertDontSee('Filme Fora');
    }

    public function test_movie_detail_page_shows_information_and_trailer_link(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $category = Category::create(['nome' => 'Suspense', 'slug' => 'suspense']);

        $movie = Movie::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'nome' => 'Detalhe Completo',
            'sinopse' => 'Uma sinopse exibida por inteiro.',
            'ano' => 2019,
            'categoria' => 'Suspense',
            'imagem_capa' => 'https://example.com/capa.jpg',
            'link_trailer' => 'https://example.com/trailer',
        ]);

        $movie->detail()->create([
            'diretor' => 'Diretora Teste',
            'duracao_minutos' => 95,
            'classificacao' => '14 anos',
            'observacoes' => 'Observacao adicional.',
        ]);

        $response = $this->get(route('movies.show', $movie));

        $response
            ->assertOk()
            ->assertSee('Detalhe Completo')
            ->assertSee('Uma sinopse exibida por inteiro.')
            ->assertSee('Diretora Teste')
            ->assertSee('https://example.com/trailer');
    }
}
