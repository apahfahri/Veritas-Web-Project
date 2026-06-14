<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PT Katiga Veritas Indonesia')</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons/css/all/all.min.css'>
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;
        $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        $cssFiles = $manifest['resources/js/app.js']['css'] ?? [];
    @endphp
    @if($manifest && $jsFile)
        @foreach($cssFiles as $css)
            <link rel="stylesheet" href="{{ asset('build/' . $css) }}">
        @endforeach
        <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
    @else
        <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
    @endif
</head>
<body class="min-h-screen">

    @yield('content')

</body>
</html>
