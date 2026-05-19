<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PT Katiga Veritas Indonesia')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
</head>
<body class="min-h-screen flex flex-col font-['Montserrat']">

    @include('components.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.success-modal')
    @include('components.loading-overlay')

</body>
</html>