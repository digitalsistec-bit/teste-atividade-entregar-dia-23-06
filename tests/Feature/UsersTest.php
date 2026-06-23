<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    

    // ✅ TESTE 1: Listar users
    public function test_listar_users(): void
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    // ✅ TESTE 2: Criar user com dados válidos
    public function test_criar_user_com_dados_validos(): void
    {
        $response = $this->post('/users', [
            'name'     => 'User Teste',
            'email'    => 'user@teste.com',
            'password' => 'senha123',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'user@teste.com']);
    }

    // TESTE 3: Criar user sem email — Deve falhar na validação e redirecionar de volta com erros
    public function test_criar_user_sem_email(): void
    {
        $response = $this->post('/users', [
            'name'     => 'User Teste',
            'password' => 'senha123',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    // ✅ TESTE 4: Atualizar user existente
    public function test_atualizar_user(): void
    {
        $user = User::create([
            'name'     => 'User Original',
            'email'    => 'original@teste.com',
            'password' => bcrypt('senha123'),
        ]);
        $this->put("/users/{$user->id}", [
            'name'  => 'User Atualizado',
            'email' => 'original@teste.com',
            'role'  => 'admin',
        ]);
        $this->assertDatabaseHas('users', ['name' => 'User Atualizado']);
    }

    // TESTE 5: Atualizar user inexistente — Deve retornar 404
    public function test_atualizar_user_inexistente(): void
    {
        $response = $this->put('/users/9999', ['name' => 'Qualquer']);
        $response->assertStatus(404);
    }

    // ✅ TESTE 6: Deletar user existente
    public function test_deletar_user(): void
    {
        $user = User::create([
            'name'     => 'User Deletar',
            'email'    => 'deletar@teste.com',
            'password' => bcrypt('senha123'),
        ]);
        $response = $this->delete("/users/{$user->id}");
        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // TESTE 7: Deletar user inexistente — Deve retornar 404
    public function test_deletar_user_inexistente(): void
    {
        $response = $this->delete('/users/9999');
        $response->assertStatus(404);
    }
}
