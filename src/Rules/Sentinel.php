<?php

namespace Redeyed\LaravelSentinel\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Redeyed\LaravelSentinel\SentinelVerifier;

class Sentinel implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * The token is resolved from the validated value when present, otherwise it
     * falls back to the "sentinel-token" field on the current request.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $token = is_string($value) && trim($value) !== ''
            ? $value
            : (string) request()->input('sentinel-token', '');

        $verifier = app(SentinelVerifier::class);

        if (! $verifier->verify($token, request()->ip())) {
            $fail('Human verification failed — please try again.');
        }
    }
}
