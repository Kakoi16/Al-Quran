<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>

<body class="antialiased bg-gray-100">
    @yield('content') <!-- ini tempat semua halaman masuk -->
    @livewireScripts
    @stack('scripts')
</body>
</html>
