@php
    $sentinelSiteKey = config('sentinel.site_key');
    $sentinelBaseUrl = rtrim(config('sentinel.base_url', 'https://redeyed.com'), '/');
@endphp

@once
    <script src="{{ $sentinelBaseUrl }}/sentinel.js" async></script>
@endonce

<div class="sentinel-captcha" data-sitekey="{{ $sentinelSiteKey }}"></div>
