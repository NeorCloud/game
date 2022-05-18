<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppVersionTest extends TestCase
{
    /**
     * @test
     */
    public function check_app_version_api()
    {
        $response = $this->get('/api/appVersion');
        $response->assertStatus(200);

        $response->assertSeeText(exec('git describe --tags'));
    }
}
