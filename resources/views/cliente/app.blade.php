<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar-custom{
            background: linear-gradient(135deg, #8b0000, #b1122d);
            padding: 15px 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .navbar-brand{
            color: white !important;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-link{
            color: white !important;
            margin-left: 15px;
            transition: 0.3s;
        }

        .nav-link:hover{
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .main-content{
            padding: 30px;
        }

        .footer{
            background: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #666;
            border-top: 1px solid #ddd;
        }

    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            🌹 Invernaderos Javier Domínguez
        </a>

        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.inicio') }}">Inicio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"href="{{ route('cliente.promociones') }}">Promociones</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.pedidos') }}">Mis pedidos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.carrito') }}">🛒 Carrito</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cliente.perfil') }}">👤 Perfil</a>
                </li>
<li class="nav-item">
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="nav-link btn btn-link p-0">
            Cerrar sesión
        </button>
    </form>
</li>

            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    @yield('content')
</div>

<div class="footer">
    © 2026 Invernaderos Javier Domínguez | Sistema web de gestión de pedidos
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>