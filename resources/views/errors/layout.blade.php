<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - Rewire Starter Kit</title>

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
                text-align: center;
            }

            .message {
                font-size: 20px;
                font-weight: 600;
                letter-spacing: -0.01em;
            }
        </style>
    </head>
    <body>
        <div class="message">
            @yield('message')
        </div>
    </body>
</html>
