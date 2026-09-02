<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@filmes.test'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('senha123'),
            ],
        );

        $categories = collect(['Acao', 'Drama', 'Ficcao Cientifica', 'Animacao', 'Suspense'])
            ->mapWithKeys(function (string $name) {
                $category = Category::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    ['nome' => $name],
                );

                return [$name => $category];
            });

        $movies = [
            [
                'nome' => 'Interestelar',
                'sinopse' => 'Uma equipe de exploradores viaja por um buraco de minhoca em busca de um novo lar para a humanidade.',
                'ano' => 2014,
                'categoria' => 'Ficcao Cientifica',
                'imagem_capa' => 'https://m.media-amazon.com/images/I/91kFYg4fX3L._AC_UF1000,1000_QL80_.jpg',
                'link_trailer' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'detail' => [
                    'diretor' => 'Christopher Nolan',
                    'duracao_minutos' => 169,
                    'classificacao' => '10 anos',
                    'observacoes' => 'Aventura espacial com foco em familia, tempo e sobrevivencia.',
                ],
            ],
            [
                'nome' => 'Cidade de Deus',
                'sinopse' => 'Dois jovens seguem caminhos diferentes enquanto a violencia cresce em uma comunidade do Rio de Janeiro.',
                'ano' => 2002,
                'categoria' => 'Drama',
                'imagem_capa' => 'https://m.media-amazon.com/images/I/81mlUxf5lzL._AC_UF1000,1000_QL80_.jpg',
                'link_trailer' => 'https://www.youtube.com/watch?v=dcUOO4Itgmw',
                'detail' => [
                    'diretor' => 'Fernando Meirelles',
                    'duracao_minutos' => 130,
                    'classificacao' => '18 anos',
                    'observacoes' => 'Marco do cinema brasileiro contemporaneo.',
                ],
            ],
            [
                'nome' => 'Homem-Aranha no Aranhaverso',
                'sinopse' => 'Miles Morales descobre seus poderes e encontra outras versoes do Homem-Aranha vindas de diferentes dimensoes.',
                'ano' => 2018,
                'categoria' => 'Animacao',
                'imagem_capa' => 'https://m.media-amazon.com/images/I/91m7cl6ARqL._AC_UF1000,1000_QL80_.jpg',
                'link_trailer' => 'https://www.youtube.com/watch?v=g4Hbz2jLxvQ',
                'detail' => [
                    'diretor' => 'Bob Persichetti, Peter Ramsey e Rodney Rothman',
                    'duracao_minutos' => 117,
                    'classificacao' => '10 anos',
                    'observacoes' => 'Animacao com visual inspirado em quadrinhos.',
                ],
            ],
            [
                'nome' => 'Mad Max: Estrada da Furia',
                'sinopse' => 'Em um deserto pos-apocaliptico, Max e Furiosa atravessam territorio hostil para escapar de um tirano.',
                'ano' => 2015,
                'categoria' => 'Acao',
                'imagem_capa' => 'https://m.media-amazon.com/images/I/81gUxkyGByL._AC_UF1000,1000_QL80_.jpg',
                'link_trailer' => 'https://www.youtube.com/watch?v=hEJnMQG9ev8',
                'detail' => [
                    'diretor' => 'George Miller',
                    'duracao_minutos' => 120,
                    'classificacao' => '16 anos',
                    'observacoes' => 'Acao pratica e ritmo intenso do inicio ao fim.',
                ],
            ],
            [
                'nome' => 'A Origem',
                'sinopse' => 'Um ladrao especializado em invadir sonhos recebe a missao de implantar uma ideia na mente de um alvo.',
                'ano' => 2010,
                'categoria' => 'Suspense',
                'imagem_capa' => 'https://m.media-amazon.com/images/I/91Rc8cAmnAL._AC_UF1000,1000_QL80_.jpg',
                'link_trailer' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'detail' => [
                    'diretor' => 'Christopher Nolan',
                    'duracao_minutos' => 148,
                    'classificacao' => '14 anos',
                    'observacoes' => 'Suspense de ficcao com camadas de realidade e sonho.',
                ],
            ],
        ];

        foreach ($movies as $movieData) {
            $detail = $movieData['detail'];
            unset($movieData['detail']);

            $category = $categories[$movieData['categoria']];

            $movie = Movie::updateOrCreate(
                ['nome' => $movieData['nome']],
                [
                    ...$movieData,
                    'category_id' => $category->id,
                    'user_id' => $admin->id,
                ],
            );

            $movie->detail()->updateOrCreate(
                ['movie_id' => $movie->id],
                $detail,
            );
        }
    }
}
