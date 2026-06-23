<?php

namespace Tests\Feature;

use App\Models\Biblioteca;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PessoasTest extends TestCase
{
    use RefreshDatabase;
   

    private function criarBiblioteca()
    {
        $user = User::create([
            'name'     => 'Usuário Teste',
            'email'    => 'teste@email.com',
            'password' => bcrypt('senha123'),
        ]);
        return Biblioteca::create([
            'created_by' => $user->id,
            'nome'       => 'Biblioteca Teste',
            'endereco'   => 'Rua Teste, 123',
        ]);
    }

    // ✅ TESTE 1: Listar pessoas
    public function test_listar_pessoas(): void
    {
        $response = $this->get('/pessoas');
        $response->assertStatus(200);
    }

    // ✅ TESTE 2: Criar pessoa com dados válidos
    public function test_criar_pessoa_com_dados_validos(): void
    {
        $biblioteca = $this->criarBiblioteca();
        $response = $this->post('/pessoas', [
            'biblioteca_id' => $biblioteca->id,
            'name'          => 'Pessoa Teste',
            'email'         => 'pessoa@teste.com',
            'password'      => 'senha123',
            'confirmPassword' => 'senha123',
        ]);
        $this->assertDatabaseHas('pessoas', ['name' => 'Pessoa Teste']);
    }

    // TESTE 3: Criar pessoa sem nome — Deve falhar na validação e redirecionar de volta com erros
    public function test_criar_pessoa_sem_nome(): void
    {
        $response = $this->post('/pessoas', [
            'email' => 'pessoa@teste.com',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    // ✅ TESTE 4: Atualizar pessoa existente
    public function test_atualizar_pessoa(): void
    {
        $biblioteca = $this->criarBiblioteca();
        $pessoa = Pessoa::create([
            'biblioteca_id' => $biblioteca->id,
            'name'          => 'Pessoa Original',
            'email'         => 'original@teste.com',
            'password'      => bcrypt('senha123'),
        ]);
        $this->put("/pessoas/{$pessoa->id}", [
            'name'  => 'Pessoa Atualizada',
            'email' => 'atualizada@teste.com',
        ]);
        $this->assertDatabaseHas('pessoas', ['name' => 'Pessoa Atualizada']);
    }

    // TESTE 5: Atualizar pessoa inexistente — Deve retornar 404
    public function test_atualizar_pessoa_inexistente(): void
    {
        $response = $this->put('/pessoas/9999', ['name' => 'Qualquer']);
        $response->assertStatus(404);
    }

    // TESTE 6: Deletar pessoa existente — Deve deletar com sucesso
    public function test_deletar_pessoa(): void
    {
        $biblioteca = $this->criarBiblioteca();
        $pessoa = Pessoa::create([
            'biblioteca_id' => $biblioteca->id,
            'name'          => 'Pessoa Deletar',
            'email'         => 'deletar@teste.com',
            'password'      => bcrypt('senha123'),
        ]);
        $response = $this->delete("/pessoas/{$pessoa->id}");
        $response->assertRedirect('/pessoas');
        $this->assertDatabaseMissing('pessoas', ['id' => $pessoa->id]);
    }

    // TESTE 7: Deletar pessoa inexistente — Deve retornar 404
    public function test_deletar_pessoa_inexistente(): void
    {
        $response = $this->delete('/pessoas/9999');
        $response->assertStatus(404);
    }
}
