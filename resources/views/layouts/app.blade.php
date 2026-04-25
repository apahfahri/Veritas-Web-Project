<!DOCTYPE html>
<html>
<head>
    <title>Veritas</title>
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
</head>
<body class="min-h-screen flex flex-col">

    @include('components.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>