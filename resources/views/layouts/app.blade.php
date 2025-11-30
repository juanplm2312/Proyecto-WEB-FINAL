<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Intercambio de Regalos')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
  @include('partials.navbar')
  <main class="container mx-auto p-4">
    @include('partials.flash')
    @yield('content')
  </main>
</body>
</html>
