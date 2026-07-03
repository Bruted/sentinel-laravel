# Redeyed Sentinel for Laravel

Add **Redeyed Sentinel** — a self-hosted CAPTCHA + IP-reputation service — to any
Laravel app in a couple of minutes.

Sentinel is **free to install** and completely **inert until you set your keys**.
Before keys are configured the package fails *open* (verification passes and a
warning is logged) so your forms never break. Once your keys are in place,
every protected form is verified server-side.

## Requirements

- PHP >= 8.1
- Laravel 10 or 11

## Installation

```bash
composer require redeyed/sentinel-laravel
```

The service provider is auto-discovered — there is nothing to register manually.

Optionally publish the config:

```bash
php artisan vendor:publish --tag=sentinel-config
```

## Configuration

Grab both keys from the **Redeyed Lab → Sentinel → Sites** (each site has both):

- **Site key** (public): renders the widget — safe in page markup.
- **Secret key** (private): verifies tokens server-side — shown once when you
  create the site.

Add them to your `.env`:

```dotenv
SENTINEL_SITE_KEY=st_pub_your-public-site-key
SENTINEL_SECRET_KEY=st_sec_your-secret-key

# Optional — only change if you self-host Sentinel elsewhere
# SENTINEL_BASE_URL=https://redeyed.com
```

The `SENTINEL_SECRET_KEY` is **secret** and stays server-side — it is only ever
sent to the verification endpoint and is never exposed to the browser. **No
developer API key is required.**

## Usage

### 1. Render the widget in your form

Drop the component anywhere inside your `<form>`:

```blade
<form method="POST" action="/register">
    @csrf

    {{-- ...your fields... --}}

    <x-sentinel-captcha />

    <button type="submit">Submit</button>
</form>
```

Prefer a directive? `@sentinel` does exactly the same thing:

```blade
<form method="POST" action="/register">
    @csrf
    @sentinel
    <button type="submit">Submit</button>
</form>
```

The widget loads the Sentinel script once per page and injects a hidden input
named `sentinel-token` into your form.

#### Customising the widget (optional)

The widget accepts four **optional** settings. Leave them unset and nothing
changes — the widget renders exactly as before (just `data-sitekey`). Each one
is rendered as a `data-*` attribute only when non-empty.

| Option       | `data-*`          | Values                                         |
| ------------ | ----------------- | ---------------------------------------------- |
| `widget`     | `data-widget`     | `behavioral` \| `checkbox` \| `press_hold` \| `image_pick` |
| `theme`      | `data-theme`      | `auto` \| `light` \| `dark`                    |
| `scheme`     | `data-scheme`     | colour scheme name                             |
| `difficulty` | `data-difficulty` | `easy` \| `medium` \| `hard` \| `max`, or `1`–`6` |

> **Note:** `difficulty` only **raises** the challenge strength above the
> adaptive baseline. A risky visitor is always challenged hard regardless of
> this value.

Set them **per instance** via component props (these override the config
defaults):

```blade
<x-sentinel-captcha widget="press_hold" theme="dark" difficulty="hard" />
```

…or set **project-wide defaults** in the published `config/sentinel.php`
(or via `.env`):

```dotenv
SENTINEL_WIDGET=checkbox
SENTINEL_THEME=auto
SENTINEL_SCHEME=midnight
SENTINEL_DIFFICULTY=medium
```

### 2. Verify on the server

Add the rule to your validation. Either use the rule class:

```php
use Redeyed\LaravelSentinel\Rules\Sentinel;

$request->validate([
    // ...your other rules...
    'sentinel-token' => ['required', new Sentinel],
]);
```

…or the string alias:

```php
$request->validate([
    'sentinel-token' => ['required', 'sentinel'],
]);
```

If verification fails the user sees:

> Human verification failed — please try again.

## How verification works

On submit, the package POSTs to `{BASE_URL}/sentinel/siteverify` with a JSON body
of `{"secret": "...", "response": "<token>"}` — reCAPTCHA-style. The site secret
authenticates the call, so **no developer API key is involved**. The submission
passes only when the response reports `success === true`.

If the secret is not configured, verification fails **open** and logs a warning
so forms keep working until you finish setup.

## License

MIT © 2026 Redeyed Corporation
