<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaptchaAlternativeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: rechaza login cuando CAPTCHA es inválido
     */
    public function test_login_fails_when_turnstile_is_invalid(): void
    {
        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response([
                'success' => false,
            ], 200),
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'cf-turnstile-response' => 'fake-token',
        ]);

        $response->assertSessionHasErrors([
            'cf-turnstile-response',
        ]);
    }

    /**
     * Test: permite login cuando CAPTCHA es válido
     */
    public function test_login_passes_when_turnstile_is_valid(): void
    {
        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'cf-turnstile-response' => 'valid-token',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }
}