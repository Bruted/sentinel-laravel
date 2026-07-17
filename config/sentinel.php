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
    | Widget Defaults (optional)
    |--------------------------------------------------------------------------
    |
    | Project-wide defaults for the widget's appearance and challenge. Each is
    | rendered as a data-* attribute on the widget only when non-empty, so
    | leaving them null keeps the current behaviour (just data-sitekey). Any of
    | these can be overridden per-instance via the component props, e.g.
    | <x-sentinel-captcha widget="press_hold" theme="dark" difficulty="hard" />.
    |
    | - widget:     which challenge variant to render
    |               (behavioral|checkbox|press_hold|image_pick).
    | - theme:      auto|light|dark.
    | - scheme:     colour scheme name.
    | - difficulty: easy|medium|hard|max, or 1-6. NOTE: difficulty only RAISES
    |               challenge strength above the adaptive baseline — a risky
    |               visitor is always challenged hard regardless of this value.
    | - width:      fixed widget width, e.g. full, 100% or 340px.
    |
    */

    'widget' => env('SENTINEL_WIDGET'),

    'theme' => env('SENTINEL_THEME'),

    'scheme' => env('SENTINEL_SCHEME'),

    'difficulty' => env('SENTINEL_DIFFICULTY'),

    'width' => env('SENTINEL_WIDTH'),

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
