<?php

namespace Redeyed\LaravelSentinel;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SentinelVerifier
{
    /**
     * Verify a Sentinel token against the Sentinel service.
     *
     * Fail-open behavior: if the site key or API key is not configured, the
     * service is treated as INERT and verification passes (a warning is logged)
     * so that forms never break before keys are set.
     *
     * @param  string       $token  The hidden "sentinel-token" submitted by the widget.
     * @param  string|null  $ip     Optional originating IP (reserved for future use).
     */
    public function verify(string $token, ?string $ip = null): bool
    {
        $secretKey = (string) config('sentinel.secret_key', '');
        $baseUrl   = rtrim((string) config('sentinel.base_url', 'https://redeyed.com'), '/');
        $timeout   = (int) config('sentinel.timeout', 10);

        // Fail OPEN when the secret is empty so forms keep working until configured.
        if ($secretKey === '') {
            Log::warning('Redeyed Sentinel is inert: SENTINEL_SECRET_KEY is not set. Verification is passing through (fail-open).');

            return true;
        }

        // No token means the widget did not produce a response — fail closed.
        if (trim($token) === '') {
            return false;
        }

        try {
            // reCAPTCHA-style: the site SECRET authenticates the call — no API key.
            $response = Http::timeout($timeout)
                ->acceptJson()
                ->asJson()
                ->post($baseUrl . '/sentinel/siteverify', array_filter([
                    'secret'   => $secretKey,
                    'response' => $token,
                    'remoteip' => $ip,
                ]));
        } catch (Throwable $e) {
            Log::warning('Redeyed Sentinel verification request failed: ' . $e->getMessage());

            return false;
        }

        if (! $response->successful()) {
            return false;
        }

        $json = $response->json();

        if (! is_array($json)) {
            return false;
        }

        // Handle the {data:{success:true}, meta:{}} envelope and a flat shape.
        $success = data_get($json, 'data.success');

        if ($success === null) {
            $success = data_get($json, 'success');
        }

        return $success === true;
    }
}
