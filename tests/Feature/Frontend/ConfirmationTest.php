<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class ConfirmationTest.
 * no more confirm is in the app
 */
class ConfirmationTest extends TestCase
{
    /** @stunTest */
    public function a_user_can_access_the_confirm_password_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/password/confirm')->assertOk();
    }
}
