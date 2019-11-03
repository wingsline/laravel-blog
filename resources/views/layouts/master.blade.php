<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, viewport-fit=cover, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | {{ config('app.name') }}</title>

    <!-- Styles -->
    <link nonce="{{ csp_nonce() }}" rel="stylesheet" href="{{ mix('main.css', 'vendor/wingsline') }}">
</head>
<body class="bg-gray-200 font-body">
    <div id="app">
        @yield('content')
    </div>
    <script nonce="{{ csp_nonce() }}" src="{{ mix('app.js', 'vendor/wingsline') }}"></script>
</body>
</html>
