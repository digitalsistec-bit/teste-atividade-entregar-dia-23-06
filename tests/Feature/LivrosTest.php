<?php
namespace Tests\Feature;
use App\Models\Livro;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class LivrosTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_listar_livros(): void
    {
        $response = $this->get('/livros');
        $response->assertStatus(200);
    }

    public function test_criar_livro_com_dados_validos(): void
    {
        $autor = Autor::create([
            'nome'  => 'Autor Teste',
            'email' => 'autor@teste.com',
        ]);
        $response = $this->post('/livros', [
            'titulo'          => 'Livro Teste',
            'isbn'            => '1234567890',
            'data_publicacao' => '2020-01-01',
            'autor_id'        => $autor->id,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('livros', ['titulo' => 'Livro Teste']);
    }

    public function test_criar_livro_sem_titulo(): void
    {
        $response = $this->post('/livros', [
            'isbn' => '123',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['titulo']);
    }

    public function test_atualizar_livro(): void
    {
        $autor = Autor::create([
            'nome'  => 'Autor Teste',
            'email' => 'autor@teste.com',
        ]);
        $livro = Livro::create([
            'titulo'          => 'Livro Original',
            'isbn'            => '1234567890',
            'data_publicacao' => '2020-01-01',
            'autor_id'        => $autor->id,
        ]);
        $response = $this->put("/livros/update/{$livro->id}", [
            'titulo'          => 'Livro Atualizado',
            'isbn'            => '1234567890',
            'data_publicacao' => '2020-01-01',
            'autor_id'        => $autor->id,
        ]);
        $response->assertStatus(302);
    }

    public function test_atualizar_livro_inexistente(): void
    {
        $response = $this->put('/livros/update/9999', ['titulo' => 'Qualquer']);
        $response->assertStatus(404);
    }

    public function test_deletar_livro(): void
    {
        $autor = Autor::create([
            'nome'  => 'Autor Teste',
            'email' => 'autor@teste.com',
        ]);
        $livro = Livro::create([
            'titulo'          => 'Livro Deletar',
            'isbn'            => '0987654321',
            'data_publicacao' => '2020-01-01',
            'autor_id'        => $autor->id,
        ]);
        $response = $this->delete("/livros/{$livro->id}");
        $response->assertStatus(302);
        $this->assertDatabaseMissing('livros', ['id' => $livro->id]);
    }

    public function test_deletar_livro_inexistente(): void
    {
        $response = $this->delete('/livros/9999');
        $response->assertStatus(404);
    }
} 
