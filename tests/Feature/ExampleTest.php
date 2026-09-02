<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_admin_area_is_publicly_accessible(): void
    {
        $this->get('/admin/movies')->assertOk();
    }

    public function test_authenticated_user_can_create_movie(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('senha123'),
        ]);

        $this->actingAs($user)->post('/admin/movies', [
            'nome' => 'Central do Brasil',
            'sinopse' => 'Uma professora aposentada ajuda um menino a procurar o pai.',
            'ano' => 1998,
            'categoria' => 'Drama',
            'imagem_capa' => 'https://example.com/capa.jpg',
            'link_trailer' => 'https://www.youtube.com/watch?v=abc123',
        ])->assertRedirect('/admin/movies');

        $this->assertDatabaseHas('movies', [
            'nome' => 'Central do Brasil',
            'user_id' => $user->id,
        ]);
    }

    public function test_authenticated_user_can_see_movie_list(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin-list@example.com',
            'password' => Hash::make('senha123'),
        ]);

        $this->actingAs($user)
            ->get('/admin/movies')
            ->assertOk()
            ->assertSee('Filmes cadastrados');
    }
}
