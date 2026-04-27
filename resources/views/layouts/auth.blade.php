<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PT Katiga Veritas Indonesia')</title>
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
</head>
<body class="min-h-screen">

    @yield('content')

</body>
</html>
