<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema web para la gestión de pedidos de rosa de invernadero')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        /* === estilos originales SIN CAMBIOS === */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 130px;
        }
        #main-wrapper { flex: 1; display: flex; flex-direction: column; transition: margin-left 0.3s ease; }
        #main-wrapper.sidebar-visible { margin-left: 280px; }
        header {
            background: linear-gradient(135deg, #b1122d, #7a0c1f);
            color: #fff;
            padding: 30px 40px;
            position: fixed;
            top: 0; left: 0; width: 100%;
            z-index: 100;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .header-content {
            max-width: 1400px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-left { display: flex; align-items: center; gap: 25px; }
        .hamburger { font-size: 1.9rem; cursor: pointer; }
        .logo { display: flex; align-items: center; gap: 15px; }
        .logo-icon { font-size: 2.6rem; }
        .logo-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 600;
        }
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            position: fixed;
            top: 130px;
            left: -280px;
            bottom: 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            padding: 30px 0;
            transition: left 0.3s ease;
            z-index: 90;
        }
        .sidebar-header {
            padding: 0 30px 20px;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 20px;
        }
        .menu { list-style: none; }
        .menu-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 30px;
            color: #444;
            text-decoration: none;
        }
        .menu-item.active a {
            background-color: rgba(177, 18, 45, 0.1);
            color: #b1122d;
            font-weight: 600;
            border-left: 4px solid #b1122d;
        }
        .content { padding: 35px; }
        .content-wrapper {
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }
        footer {
            text-align: center;
            padding: 18px;
            font-size: 0.85rem;
            color: #666;
        }
    </style>

    @stack('styles')
</head>

<body>

<header>
    <div class="header-content">
        <div class="header-left">
            <div class="hamburger" id="sidebarToggle">☰</div>
            <div class="logo">
                <div class="logo-icon">🌹</div>
                <div class="logo-text">
                    <h1>Invernaderos Javier Domínguez</h1>
                    <p>Sistema web para la gestión de pedidos</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>Menú Principal</h2>
        <p>Navegación del sistema</p>
    </div>

    <ul class="menu">

        {{-- NO LOGUEADO --}}
   @if(!session('usuario_logueado'))

    <li class="menu-item {{ request()->routeIs('login') ? 'active' : '' }}">
        <a href="{{ route('login') }}">🏠 <span>Iniciar Sesión</span></a>
    </li>

    <li class="menu-item {{ request()->routeIs('register') ? 'active' : '' }}">
        <a href="{{ route('register') }}">📝 <span>Registrarse</span></a>
    </li>

@endif

        {{-- ADMIN Y EMPLEADO --}}
        @if(session('usuario_logueado') && in_array(session('rol'), ['admin', 'empleado']))
            <li class="menu-item {{ request()->is('plantas*') ? 'active' : '' }}">
                <a href="{{ route('productos.index') }}">🌹 <span>Productos </span></a>
            </li>

            <li class="menu-item {{ request()->is('inventario*') ? 'active' : '' }}">
                <a href="{{ url('/inventario') }}">📦 <span>Inventario</span></a>
            </li>

            <li class="menu-item {{ request()->is('proveedores*') ? 'active' : '' }}">
                <a href="{{ url('/proveedores') }}">🚚 <span>Proveedores</span></a>
            </li>

            {{-- SOLO ADMIN --}}
            @if(session('rol') === 'admin')
                <li class="menu-item {{ request()->is('admon/usuarios*') ? 'active' : '' }}">
                    <a href="{{ url('admon/usuarios') }}">👤 <span>Usuarios</span></a>
                </li>
            @endif

            {{-- 🔥 PROMOCIONES (ADMIN / EMPLEADO) --}}
            <li class="menu-item {{ request()->is('admin/promociones*') ? 'active' : '' }}">
                <a href="{{ route('admin.promociones') }}">🏷️ <span>Promociones</span></a>
            </li>
        @endif

    </ul>
</aside>

<div id="main-wrapper">
    <main class="content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    <footer>
        © {{ date('Y') }} Invernaderos Javier Domínguez
    </footer>
</div>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('main-wrapper');

        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-280px';
            mainWrapper.classList.remove('sidebar-visible');
        } else {
            sidebar.style.left = '0px';
            mainWrapper.classList.add('sidebar-visible');
        }
    });
</script>

</body>
</html>