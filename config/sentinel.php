<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sentinel Site Key (public)
    |--------------------------------------------------------------------------
    |
    | Public key used to render the widget in the browser. Grab it from the
    | Redeyed Lab panel under Developer → Sentinel Sites.
    |
    */

    'site_key' => env('SENTINEL_SITE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Sentinel API Key (secret)
    |--------------------------------------------------------------------------
    |
    | Secret key used server-side to verify tokens. It is sent as the
    | "X-Api-Key" header and must never be exposed to the browser. Grab it
    | from the Redeyed Lab panel under Developer → API Keys.
    |
    */

    'api_key' => env('SENTINEL_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The Sentinel service endpoint. Override only if you self-host Sentinel
    | on a different domain.
    |
    */

    'base_url' => env('SENTINEL_BASE_URL', 'https://redeyed.com'),

    /*
    |--------------------------------------------------------------------------
    | Verification Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum number of seconds to wait for the verify request to respond.
    |
    */

    'timeout' => 10,

];
