@props([
    'widget' => config('sentinel.widget'),
    'theme' => config('sentinel.theme'),
    'scheme' => config('sentinel.scheme'),
    'difficulty' => config('sentinel.difficulty'),
    'width' => config('sentinel.width'),
])

@php
    $sentinelSiteKey = config('sentinel.site_key');
    $sentinelBaseUrl = rtrim(config('sentinel.base_url', 'https://redeyed.com'), '/');
@endphp

@once
    <script src="{{ $sentinelBaseUrl }}/sentinel.js" async></script>
@endonce

{{-- Each optional data-* is rendered only when non-empty; a bare widget keeps the current behaviour (just data-sitekey).
     data-difficulty only RAISES challenge strength above the adaptive baseline — a risky visitor is always challenged hard regardless. --}}
<div class="sentinel-captcha" data-sitekey="{{ $sentinelSiteKey }}"@if(!empty($widget)) data-widget="{{ $widget }}"@endif @if(!empty($theme)) data-theme="{{ $theme }}"@endif @if(!empty($scheme)) data-scheme="{{ $scheme }}"@endif @if(!empty($difficulty)) data-difficulty="{{ $difficulty }}"@endif @if(!empty($width)) data-width="{{ $width }}"@endif></div>
