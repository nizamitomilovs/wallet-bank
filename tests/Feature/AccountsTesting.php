<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsTesting extends TestCase
{
    public function testOnlyUserCanSeeAccounts()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
