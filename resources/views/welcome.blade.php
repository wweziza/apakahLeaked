<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>apakahLeaked - Check NIK KTP Leaks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300 ease-in-out">
    <div class="min-h-screen flex flex-col">
        <x-navbar />
        <main class="flex-grow flex items-center justify-center px-4">
            <div class="text-center w-full max-w-md">
                <h2 class="text-3xl font-bold mb-8 text-center max-w-md mx-auto">Is your E-KTP safe?</h2>
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <form action="{{ url('/check-nik') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="text" name="nik" placeholder="Enter your NIK KTP" class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-600 mb-4 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-300">Check</button>
                    </form>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        If you're a special user, <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">click here</a>
                    </p>
                </div>
            </div>
        </main>
        <x-footer />
    </div>
    <script src="{{ asset('js/landing.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>