<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control de Alquileres')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
        <i class="bi bi-building"></i> AlquiControl
    </a>




<a href="{{ route('dashboard') }}">Dashboard</a>

<a href="{{ route('habitaciones.index') }}">Habitaciones</a>

<a href="{{ route('inquilinos.index') }}">Inquilinos</a>

<a href="{{ route('alquileres.index') }}">Alquileres</a>

<a href="{{ route('cuotas.index') }}">Cuotas</a>

<a href="{{ route('pagos.index') }}">Pagos</a>

<a href="{{ route('deudas.index') }}">Deudas</a>




</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
