<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class TurnstileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => env('TURNSTILE_SECRET_KEY'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]
        );

        $result = $response->json();

        if (!($result['success'] ?? false)) {
            $fail('La verificación CAPTCHA falló.');
        }
    }
}
