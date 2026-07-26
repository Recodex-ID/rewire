<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

        {{-- Deliberately self-contained: no @vite/@fonts/Livewire here. Error pages must still
             render correctly even if the asset build is the thing that's broken. --}}
        <style>
            * {
                box-sizing: border-box;
            }

            html, body {
                margin: 0;
                height: 100%;
            }

            body {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 24px;
                background: #fefefe;
                color: #1a2a4b;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }

            .card {
                width: 100%;
                max-width: 420px;
                text-align: center;
            }

            .logo {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                border-radius: 12px;
                background: #1a2a4b;
                margin-bottom: 28px;
            }

            .code {
                font-size: 64px;
                font-weight: 800;
                letter-spacing: -0.02em;
                line-height: 1;
                margin: 0 0 16px;
            }

            .message {
                font-size: 20px;
                font-weight: 600;
                letter-spacing: -0.01em;
                margin: 0 0 8px;
            }

            .description {
                font-size: 14px;
                line-height: 1.6;
                color: #6b7280;
                margin: 0 0 32px;
            }

            .button {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 12px 24px;
                border-radius: 999px;
                background: #1a2a4b;
                color: #fefefe;
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
            }

            .button:hover {
                background: #2a3a5b;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="logo">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#fefefe" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m5 12 5 5L20 7" />
                </svg>
            </div>

            <p class="code">@yield('code')</p>
            <h1 class="message">@yield('message')</h1>
            <p class="description">@yield('description')</p>

            <a href="{{ route('home') }}" class="button">Back to home</a>
        </div>
    </body>
</html>
