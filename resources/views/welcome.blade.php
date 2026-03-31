<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Rock Commerce API') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #0f172a;
                color: white;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            }

            .container {
                text-align: center;
            }

            .logo {
                font-size: 42px;
                font-weight: 700;
                letter-spacing: 2px;
            }

            .subtitle {
                margin-top: 10px;
                opacity: 0.7;
                font-size: 14px;
            }

            .rock {
                color: #ef4444;
            }
        </style>
    @endif
</head>
<body>
    <div class="container">
        <div class="logo">
            <span class="rock">ROCK</span>-COMMERCE
        </div>
        <div class="subtitle">
            API Service
        </div>
    </div>
</body>
</html>