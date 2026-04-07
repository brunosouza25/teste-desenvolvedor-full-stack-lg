<!DOCTYPE html>
<html lang="pt-BR" class="h-100"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LG Electronics - Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column h-100">

    @include('layouts.header')

    <main class="flex-shrink-0 container py-4">
        @yield('content')
    </main>

    @include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
