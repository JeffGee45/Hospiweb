<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenue sur Hospiweb</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
            <div class="flex justify-center mb-6">
                <img class="h-24 w-auto" src="{{ asset('images/hospital-logo.svg') }}" alt="Hospiweb Logo">
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Bienvenue Dr. {{ Auth::user()->name }}!
            </h1>
            <p class="text-gray-600 mb-8">
                Hospiweb est une application de gestion hospitalière conçue pour vous aider à suivre vos patients, leurs rendez-vous et leurs hospitalisations de manière simple et efficace.
            </p>
            <a href="{{ route('dashboard') }}" 
               onclick="event.preventDefault(); document.getElementById('get-started-form').submit();"
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out">
                Commencer maintenant
            </a>
            <form id="get-started-form" action="{{ route('get-started.complete') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>
