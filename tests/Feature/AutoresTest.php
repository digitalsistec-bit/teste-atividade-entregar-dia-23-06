<?php
namespace Tests\Feature;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AutoresTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_listar_autores(): void
    {
        $response = $this->get('/autores');
        $response->assertStatus(200);
    }

    public function test_criar_autor_com_dados_validos(): void
    {
        $response = $this->post('/autores', [
            'nome'  => 'Autor Teste',
            'email' => 'autor@teste.com',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('autores', ['nome' => 'Autor Teste']);
    }

    public function test_criar_autor_sem_nome(): void
    {
        $response = $this->post('/autores', [
            'email' => 'autor@teste.com',
        ]);
        $response->assertStatus(302);
    }

    public function test_atualizar_autor(): void
    {
        $autor = Autor::create([
            'nome'  => 'Autor Original',
            'email' => 'original@teste.com',
        ]);
        $response = $this->put("/autores/update/{$autor->id}", [
            'nome' => 'Autor Atualizado',
        ]);
        $response->assertStatus(302);
    }

    public function test_atualizar_autor_inexistente(): void
    {
        $response = $this->put('/autores/update/9999', ['nome' => 'Qualquer']);
        $response->assertStatus(404);
    }

    public function test_deletar_autor(): void
    {
        $autor = Autor::create([
            'nome'  => 'Autor Deletar',
            'email' => 'deletar@teste.com',
        ]);
        $response = $this->delete("/autores/{$autor->id}");
        $response->assertRedirect('/autores');
        $this->assertDatabaseMissing('autores', ['id' => $autor->id]);
    }

    public function test_deletar_autor_inexistente(): void
    {
        $response = $this->delete('/autores/9999');
        $response->assertStatus(404);
    }
}