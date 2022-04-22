<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class CreateUserTest.
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_create_user_page()
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/auth/user/create');

        $response->assertOk();
    }

    /** @test */
    public function create_user_requires_validation()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/user');

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'password']);
    }

    /** @test */
    public function user_email_needs_to_be_unique()
    {
        $this->loginAsAdmin();

        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post('/admin/auth/user', [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function admin_can_create_new_user()
    {
        Event::fake();

        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/user', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
            'active' => '1',
            'roles' => [
                Role::whereName(config('boilerplate.access.role.admin'))->first()->id,
            ],
        ]);

        $this->assertDatabaseHas(
            'users',
            [
                'type' => User::TYPE_ADMIN,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'active' => true,
            ]
        );

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::whereName(config('boilerplate.access.role.admin'))->first()->id,
            'model_type' => User::class,
            'model_id' => User::whereEmail('john@example.com')->first()->id,
        ]);

        $response->assertSessionHas(['flash_success' => __('The user was successfully created.')]);

        Event::assertDispatched(UserCreated::class);
    }

    /** @test */
    public function only_admin_can_create_users()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/user/create');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
