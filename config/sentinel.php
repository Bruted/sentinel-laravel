<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sentinel Site Key (public)
    |--------------------------------------------------------------------------
    |
    | Public key used to render the widget in the browser. Grab it from the
    | Redeyed Lab panel under Sentinel → Sites.
    |
    */

    'site_key' => env('SENTINEL_SITE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Sentinel Secret Key (private)
    |--------------------------------------------------------------------------
    |
    | The per-site SECRET key. Used server-side to verify tokens against
    | POST /sentinel/siteverify — reCAPTCHA-style, no developer API key needed.
    | It must never be exposed to the browser. Grab it from the Redeyed Lab
    | under Sentinel → Sites (it is shown once when you create the site).
    |
    */

    'secret_key' => env('SENTINEL_SECRET_KEY'),

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
