<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Biblioteca;

class BibliotecasTest extends TestCase
{
    use RefreshDatabase;
  

    // Cria um usuário para usar nos testes
    private function criarUsuario()
    {
        return User::create([
            'name'     => 'Usuário Teste',
            'email'    => 'teste@email.com',
            'password' => bcrypt('senha123'),
        ]);
    }

    // ✅ TESTE 1: Listar bibliotecas
    public function test_listar_bibliotecas(): void
    {
        $user = $this->criarUsuario();
        Biblioteca::create([
            'created_by' => $user->id,
            'nome'       => 'Biblioteca Central',
            'endereco'   => 'Rua A, 123',
        ]);

        $response = $this->get('/bibliotecas');
        $response->assertStatus(200);
    }

    // ✅ TESTE 2: Criar biblioteca com dados válidos
    public function test_criar_biblioteca_com_dados_validos(): void
    {
        $user = $this->criarUsuario();

        $response = $this->post('/bibliotecas/create', [
            'created_by' => $user->id,
            'nome'       => 'Biblioteca Nova',
            'endereco'   => 'Rua B, 456',
        ]);

        $response->assertRedirect('/bibliotecas');
        $this->assertDatabaseHas('bibliotecas', ['nome' => 'Biblioteca Nova']);
    }

    // ✅ TESTE 3: Criar biblioteca sem nome (deve falhar)
    public function test_criar_biblioteca_sem_nome(): void
    {
        $user = $this->criarUsuario();

        $response = $this->post('/bibliotecas/create', [
            'created_by' => $user->id,
            'nome'       => '',
            'endereco'   => 'Rua C, 789',
        ]);

        $this->assertDatabaseMissing('bibliotecas', ['endereco' => 'Rua C, 789']);
    }

    // ✅ TESTE 4: Atualizar biblioteca existente
    public function test_atualizar_biblioteca(): void
    {
        $user = $this->criarUsuario();
        $biblioteca = Biblioteca::create([
            'created_by' => $user->id,
            'nome'       => 'Biblioteca Antiga',
            'endereco'   => 'Rua D, 100',
        ]);

        $response = $this->put("/bibliotecas/update/{$biblioteca->id}", [
            'nome'     => 'Biblioteca Atualizada',
            'endereco' => 'Rua D, 200',
        ]);

        $this->assertDatabaseHas('bibliotecas', ['nome' => 'Biblioteca Atualizada']);
    }

    // ✅ TESTE 5: Atualizar biblioteca que não existe
    public function test_atualizar_biblioteca_inexistente(): void
    {
        $response = $this->put('/bibliotecas/update/9999', [
            'nome' => 'Qualquer Nome',
        ]);

        $response->assertStatus(404);
    }

    // ✅ TESTE 6: Deletar biblioteca existente
    public function test_deletar_biblioteca(): void
    {
        $user = $this->criarUsuario();
        $biblioteca = Biblioteca::create([
            'created_by' => $user->id,
            'nome'       => 'Biblioteca para Deletar',
            'endereco'   => 'Rua E, 500',
        ]);

        $response = $this->delete("/bibliotecas/delete/{$biblioteca->id}");
        $this->assertDatabaseMissing('bibliotecas', ['id' => $biblioteca->id]);
    }

    // ✅ TESTE 7: Deletar biblioteca que não existe
    public function test_deletar_biblioteca_inexistente(): void
    {
        $response = $this->delete('/bibliotecas/delete/9999');
        $response->assertStatus(404);
    }
}
