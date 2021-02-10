<!DOCTYPE html>
<html>
<head>
    @meta_tags
    <meta name="fragment" content="!" />

    <!-- Auth Token -->
    @if (session('token'))
        <meta name="token" content="{{ session('token') }}">
    @endif

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <app/>
    </div>
</body>
</html>
