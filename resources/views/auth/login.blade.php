<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Hospiweb</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-center mb-6">
                <img class="h-24 w-auto" src="{{ asset('images/hospital-logo.svg') }}" alt="Hospiweb Logo">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Se connecter à votre compte</h2>

            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('email') }}">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="block w-full px-3 py-2 mt-1 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg id="password-eye-icon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.43-7.088a1.012 1.012 0 0 1 1.58 0l4.43 7.088a1.012 1.012 0 0 1 0 .639l-4.43 7.088a1.012 1.012 0 0 1-1.58 0l-4.43-7.088Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Se connecter
                    </button>
                </div>
            </form>
            <p class="text-sm text-center text-gray-600">
                Pas encore de compte?
                <a href="{{ route('register') }}"
                    class="font-medium text-indigo-600 hover:text-indigo-500">S'inscrire</a>
            </p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />`;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.43-7.088a1.012 1.012 0 0 1 1.58 0l4.43 7.088a1.012 1.012 0 0 1 0 .639l-4.43 7.088a1.012 1.012 0 0 1-1.58 0l-4.43-7.088Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />`;
            }
        }
    </script>
</body>

</html>
