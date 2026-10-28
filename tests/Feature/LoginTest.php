<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guests visiting home route receive the login screen.
     */
    public function test_guest_visiting_home_sees_login_screen(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Memorando');
        $response->assertSee('Usuário');
        $response->assertSee('Senha');
        $response->assertSee('Entrar');
        $response->assertSee('Se você ainda não alterou sua senha,');
        $response->assertSee('ti.esteio.rs.gov.br/mudasenha');
        $response->assertDontSee('Beacon');
        $response->assertDontSee('Incident response for teams on call');
        $response->assertDontSee('Continue with Google');
        $response->assertDontSee('Continue with GitHub');
        $response->assertDontSee('Start a 14-day trial');
    }

    /**
     * Test that guests visiting /login see the login screen.
     */
    public function test_guest_visiting_login_route_sees_login_screen(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Memorando');
    }

    /**
     * Test that authenticated users visiting home see the dashboard with legado elements.
     */
    public function test_authenticated_user_sees_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Kleyton Fantin',
            'email' => 'kleyton@esteio.rs.gov.br',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Bem vindo,');
        $response->assertSee('Kleyton Fantin');
        $response->assertSee('No menu à esquerda, você tem acesso aos sistemas.');
        $response->assertSee('No menu acima, você terá acesso aos módulos do sistema aberto.');
        $response->assertSee('Consultar memorandos');
        $response->assertSee('Correção do Cartão-Ponto');
        $response->assertSee('Criar memorando');
        $response->assertSee('Criar circular');
        $response->assertSee('Trocar senha');
        $response->assertSee('Sair');
    }

    /**
     * Test login validation errors when fields are empty.
     */
    public function test_login_validation_requires_usuario_and_senha(): void
    {
        $response = $this->post('/login', [
            'usuario_login' => '',
            'usuario_senha' => '',
        ]);

        $response->assertSessionHasErrors([
            'usuario_login' => 'Preencha o login',
            'usuario_senha' => 'Preencha a senha',
        ]);
    }

    /**
     * Test invalid login credentials return error message.
     */
    public function test_invalid_login_returns_error(): void
    {
        $response = $this->post('/login', [
            'usuario_login' => 'usuario_inexistente',
            'usuario_senha' => 'senha123',
        ]);

        $response->assertSessionHasErrors([
            'usuario_login' => 'Login e/ou senha inválido(s)',
        ]);
    }

    /**
     * Test successful login redirects to home.
     */
    public function test_successful_login(): void
    {
        $user = User::factory()->create([
            'login' => '12345678900',
            'name' => 'Servidor Teste',
            'email' => 'servidor@esteio.rs.gov.br',
            'password' => bcrypt('senha123'),
        ]);

        $response = $this->post('/login', [
            'usuario_login' => '12345678900',
            'usuario_senha' => 'senha123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test logout redirects to home with message.
     */
    public function test_logout_redirects_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('home'));
        $this->assertGuest();
        $response->assertSessionHas('status', 'Você saiu do sistema');
    }

    /**
     * Test that guests cannot access the password change page.
     */
    public function test_guest_cannot_access_password_change_page(): void
    {
        $response = $this->get('/trocar-senha');

        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can view password change page with legado fields and buttons.
     */
    public function test_authenticated_user_can_view_password_change_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/trocar-senha');

        $response->assertStatus(200);
        $response->assertSee('Trocar senha');
        $response->assertSee('Senha atual');
        $response->assertSee('Nova senha');
        $response->assertSee('Repita a nova senha');
        $response->assertSee('Salvar');
        $response->assertSee('Cancelar');
    }

    /**
     * Test password change validation requires all fields.
     */
    public function test_password_change_validation_requires_all_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/trocar-senha', [
            'senha_atual' => '',
            'nova_senha' => '',
            'repita_senha' => '',
        ]);

        $response->assertSessionHasErrors([
            'senha_atual' => 'Preencha a senha atual',
            'nova_senha' => 'Preencha a nova senha',
            'repita_senha' => 'Repita a nova senha',
        ]);
    }

    /**
     * Test password change rejects incorrect current password.
     */
    public function test_password_change_rejects_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('senha-antiga'),
        ]);

        $response = $this->actingAs($user)->post('/trocar-senha', [
            'senha_atual' => 'senha-errada',
            'nova_senha' => 'nova-senha-123',
            'repita_senha' => 'nova-senha-123',
        ]);

        $response->assertSessionHasErrors(['senha_atual']);
    }

    /**
     * Test password change rejects mismatched new passwords.
     */
    public function test_password_change_rejects_mismatched_new_passwords(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('senha-antiga'),
        ]);

        $response = $this->actingAs($user)->post('/trocar-senha', [
            'senha_atual' => 'senha-antiga',
            'nova_senha' => 'nova-senha-123',
            'repita_senha' => 'outra-senha',
        ]);

        $response->assertSessionHasErrors(['repita_senha']);
    }

    /**
     * Test password change successfully updates user password.
     */
    public function test_password_change_successfully_updates_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('senha-antiga'),
        ]);

        $response = $this->actingAs($user)->post('/trocar-senha', [
            'senha_atual' => 'senha-antiga',
            'nova_senha' => 'nova-senha-forte',
            'repita_senha' => 'nova-senha-forte',
        ]);

        $response->assertRedirect(route('password.change'));
        $response->assertSessionHas('status', 'Senha trocada com sucesso');

        $user->refresh();
        $this->assertTrue(Hash::check('nova-senha-forte', $user->password));
    }
}
