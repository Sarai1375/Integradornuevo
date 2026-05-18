@extends('cpanel.app')

@section('title', 'Panel Administrador')

@section('content')

<style>
    body{
        background: #f4f5f9;
    }

    .container-shop{
        padding: 35px;
    }

    /* BIENVENIDA */
    .welcome-box{
        background: linear-gradient(135deg, #8b0000, #c40000);
        border-radius: 28px;
        padding: 45px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
    }

    .welcome-box::before{
        content: "🌹";
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 110px;
        opacity: 0.12;
    }

    .welcome-title{
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .welcome-text{
        font-size: 1.05rem;
        opacity: 0.92;
        max-width: 700px;
        line-height: 1.7;
    }

    /* GRID TARJETAS */
    .dashboard-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
    }

    /* TARJETAS */
    .dashboard-card{
        background: white;
        border: none;
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .dashboard-card:hover{
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }

    .dashboard-card::after{
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        top: -40px;
        right: -40px;
    }

    .dashboard-icon{
        width: 75px;
        height: 75px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 22px;
        color: white;
        box-shadow: 0 6px 15px rgba(0,0,0,0.12);
    }

    .bg-red{
        background: linear-gradient(135deg, #8b0000, #d10000);
    }

    .bg-blue{
        background: linear-gradient(135deg, #005bea, #00c6fb);
    }

    .bg-green{
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    .bg-orange{
        background: linear-gradient(135deg, #ff8008, #ffc837);
    }

    .bg-purple{
        background: linear-gradient(135deg, #6a11cb, #9b59ff);
    }

    .bg-dark{
        background: linear-gradient(135deg, #232526, #414345);
    }

    .dashboard-title{
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #222;
    }

    .dashboard-text{
        color: #777;
        margin-bottom: 22px;
        line-height: 1.6;
        min-height: 48px;
    }

    .btn-panel{
        border: none;
        border-radius: 14px;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-panel:hover{
        transform: scale(1.02);
    }

    /* BOTÓN LOGOUT */
    .logout-container{
        display: flex;
        justify-content: center;
        margin-top: 45px;
    }

    .btn-logout{
        background: linear-gradient(135deg, #8b0000, #c40000);
        border: none;
        color: white;
        padding: 14px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 8px 20px rgba(139,0,0,0.25);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-logout:hover{
        transform: translateY(-3px);
        background: linear-gradient(135deg, #a30000, #ff0000);
        color: white;
    }

    /* RESPONSIVE */
    @media(max-width: 768px){

        .container-shop{
            padding: 20px;
        }

        .welcome-box{
            padding: 30px;
        }

        .welcome-title{
            font-size: 2rem;
        }

        .welcome-box::before{
            font-size: 80px;
        }
    }
</style>

<div class="container-shop">

    <!-- BIENVENIDA -->
    <div class="welcome-box">

        <h1 class="welcome-title">
            ¡Bienvenido, {{ session('nombre') }}! 👋
        </h1>

        <p class="welcome-text">
            Panel de administración de Invernaderos Javier Domínguez.
            Gestiona productos, inventario, promociones, usuarios,
            proveedores y pedidos desde un solo lugar.
        </p>

    </div>

    <!-- TARJETAS -->
    <div class="dashboard-grid">

        <!-- PRODUCTOS -->
        <div class="dashboard-card">

            <div class="dashboard-icon bg-red">
                🌹
            </div>

            <h4 class="dashboard-title">
                Productos
            </h4>

            <p class="dashboard-text">
                Administra el catálogo de rosas disponibles.
            </p>

            <a href="{{ route('productos.index') }}"
               class="btn btn-danger btn-panel w-100">
                Gestionar
            </a>

        </div>

        <!-- INVENTARIO -->
        <div class="dashboard-card">

            <div class="dashboard-icon bg-purple">
                📦
            </div>

            <h4 class="dashboard-title">
                Inventario
            </h4>

            <p class="dashboard-text">
                Controla existencias, entradas y salidas de productos.
            </p>

            <a href="{{ route('inventario.index') }}" class="btn btn-primary btn-panel w-100">
                Ver inventario
            </a>

        </div>

        <!-- USUARIOS -->
        <div class="dashboard-card">

            <div class="dashboard-icon bg-blue">
                👥
            </div>

            <h4 class="dashboard-title">
                Usuarios
            </h4>

            <p class="dashboard-text">
                Consulta clientes, empleados y administradores.
            </p>

            <a href="{{ route('usuarios.index') }}"
               class="btn btn-primary btn-panel w-100">
                Ver usuarios
            </a>

        </div>

        <!-- PROVEEDORES -->
        <div class="dashboard-card">

            <div class="dashboard-icon bg-dark">
                🚚
            </div>

            <h4 class="dashboard-title">
                Proveedores
            </h4>

            <p class="dashboard-text">
                Gestiona información y contacto de proveedores.
            </p>

        <a href="{{ route('proveedores.index') }}"
            class="btn btn-dark btn-panel w-100">
                Administrar
        </a>

        </div>

        <!-- PROMOCIONES -->
        <div class="dashboard-card">

            <div class="dashboard-icon bg-green">
                🏷️
            </div>

            <h4 class="dashboard-title">
                Promociones
            </h4>

            <p class="dashboard-text">
                Crea descuentos y ofertas especiales.
            </p>

            <a href="{{ route('admin.promociones') }}"
               class="btn btn-success btn-panel w-100">
                Administrar
            </a>

        </div>
        <!-- GESTIÓN DE PEDIDOS -->

        <div class="dashboard-card" >
        <div class="dashboard-icon bg-dark" >
        📋​
        </div>

        <h4 class="dashboard-title">
            Gestión de pedidos
        </h4>

        <p class="dashboard-text">
            Administra pedidos, pagos, envíos y seguimiento de clientes.
        </p>

        <a href="{{ route('admin.pedidos') }}"
       class="btn btn-success btn-panel w-100">

        Ver pedidos

    </a>

</div>

    </div>
    

    <!-- BOTÓN LOGOUT -->
    <div class="logout-container">

        <form action="{{ route('logout') }}"
              method="POST">

            @csrf

            <button type="submit" class="btn-logout">
                Cerrar sesión
            </button>

        </form>

    </div>

</div>

@endsection