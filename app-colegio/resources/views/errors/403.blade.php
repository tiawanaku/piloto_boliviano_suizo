{{-- Página 403 liviana (HU-007): sin JavaScript ni recursos externos. --}}
@php
    $user = auth()->user();
    $homeUrl = $user instanceof \App\Models\User ? $user->primaryPanelUrl() : null;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ __('errors.403.title') }} · {{ config('app.name') }}</title>
    <style>
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: system-ui, sans-serif; background: #f8fafc; color: #1e293b; }
        main { max-width: 32rem; padding: 2rem; text-align: center; }
        h1 { font-size: 1.5rem; margin: 0 0 .75rem; }
        p { margin: 0 0 1.5rem; color: #475569; }
        a { display: inline-block; padding: .625rem 1.25rem; border-radius: .5rem; background: #2563eb; color: #fff; text-decoration: none; }
        a:focus-visible { outline: 3px solid #93c5fd; outline-offset: 2px; }
    </style>
</head>
<body>
    <main>
        <h1>{{ __('errors.403.message') }}</h1>
        <p>{{ __('errors.403.help') }}</p>
        @if ($homeUrl)
            <a href="{{ $homeUrl }}">{{ __('errors.403.back_to_panel') }}</a>
        @elseif (! $user)
            <a href="{{ url('/admin/login') }}">{{ __('errors.403.login') }}</a>
        @endif
    </main>
</body>
</html>
