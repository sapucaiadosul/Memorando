<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_users_management(): void
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
        $this->get(route('users.create'))->assertRedirect(route('login'));
    }

    public function test_non_admin_user_receives_forbidden_on_users_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('users.create'))
            ->assertForbidden();
    }

    public function test_admin_sees_users_link_on_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('users.index'), false);
        $response->assertSee('Usuários');
    }

    public function test_admin_can_list_and_search_users(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrador Geral',
            'login' => 'admin.geral',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Maria Silva',
            'login' => 'maria.silva',
            'desativado' => false,
        ]);

        User::factory()->create([
            'name' => 'João Inativo',
            'login' => 'joao.inativo',
            'desativado' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('users.index', ['search' => 'Maria']));
        $response->assertOk();
        $response->assertSee('Maria Silva');
        $response->assertDontSee('João Inativo');

        $allResponse = $this->actingAs($admin)->get(route('users.index', ['status' => 'todos']));
        $allResponse->assertOk();
        $allResponse->assertSee('Maria Silva');
        $allResponse->assertSee('João Inativo');
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Novo Servidor',
            'login' => 'novo.servidor',
            'email' => 'novo@sapucaiadosul.rs.gov.br',
            'password' => '123456',
            'password_confirmation' => '123456',
            'is_admin' => '1',
            'provisoria' => '1',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('status', 'Usuário cadastrado com sucesso.');

        $created = User::where('login', 'novo.servidor')->first();
        $this->assertNotNull($created);
        $this->assertSame('Novo Servidor', $created->name);
        $this->assertTrue($created->is_admin);
        $this->assertTrue($created->provisoria);
        $this->assertFalse($created->desativado);
        $this->assertSame($admin->id, $created->creator_id);
        $this->assertTrue(Hash::check('123456', $created->password));
    }

    public function test_admin_can_update_user_without_changing_password(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $target = User::factory()->create([
            'name' => 'Servidor Antigo',
            'login' => 'servidor.antigo',
            'password' => Hash::make('senha-original'),
            'is_admin' => false,
        ]);

        $response = $this->actingAs($admin)->put(route('users.update', $target), [
            'name' => 'Servidor Atualizado',
            'login' => 'servidor.novo',
            'email' => 'atualizado@sapucaiadosul.rs.gov.br',
            'password' => '',
            'password_confirmation' => '',
            'is_admin' => '1',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('status', 'Usuário atualizado com sucesso.');

        $target->refresh();
        $this->assertSame('Servidor Atualizado', $target->name);
        $this->assertSame('servidor.novo', $target->login);
        $this->assertTrue($target->is_admin);
        $this->assertSame($admin->id, $target->updater_id);
        $this->assertTrue(Hash::check('senha-original', $target->password));
    }

    public function test_admin_can_toggle_user_status_and_cannot_deactivate_self(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'desativado' => false]);
        $target = User::factory()->create(['desativado' => false]);

        $this->actingAs($admin)
            ->patch(route('users.toggle-status', $target))
            ->assertRedirect(route('users.index'));

        $this->assertTrue($target->fresh()->desativado);

        $this->actingAs($admin)
            ->patch(route('users.toggle-status', $target))
            ->assertRedirect(route('users.index'));

        $this->assertFalse($target->fresh()->desativado);

        $this->actingAs($admin)
            ->patch(route('users.toggle-status', $admin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHasErrors('user');

        $this->assertFalse($admin->fresh()->desativado);
    }

    public function test_admin_can_delete_other_user_but_not_self(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $target = User::factory()->create();

        $this->actingAs($admin)
            ->delete(route('users.destroy', $target))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status', 'Usuário excluído com sucesso.');

        $this->assertDatabaseMissing('users', ['id' => $target->id]);

        $this->actingAs($admin)
            ->delete(route('users.destroy', $admin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHasErrors('user');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
