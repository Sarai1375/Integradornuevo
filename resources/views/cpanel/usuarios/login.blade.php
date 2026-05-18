@extends('cpanel.app') 

@section('title', 'Iniciar Sesión')

@section('content')
<style>
    .login-container {
        max-width: 450px;
        margin: 60px auto;
        background: white;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        border-top: 5px solid #c41e3a;
        animation: fadeIn 0.7s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px);}
        to { opacity: 1; transform: translateY(0);}
    }

    .login-title {
        font-size: 1.8em;
        color: #8b0000;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .login-subtitle {
        text-align: center;
        font-size: 0.95em;
        margin-bottom: 25px;
        color: #555;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 1em;
        transition: 0.3s;
    }

    input:focus {
        border-color: #c41e3a;
        outline: none;
        box-shadow: 0 0 6px rgba(196,30,58,0.4);
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        background: #c41e3a;
        color: white;
        font-size: 1.1em;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    .login-btn:hover {
        background: #8b0000;
    }

    .extra-links {
        text-align: center;
        margin-top: 18px;
    }

    .extra-links a {
        text-decoration: none;
        color: #c41e3a;
        font-weight: bold;
    }

    .extra-links a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">

    <h2 class="login-title">Iniciar Sesión</h2>
    <p class="login-subtitle">Accede al sistema de gestión de pedidos</p>

    {{-- MENSAJE DE ERROR DEL CONTROLADOR --}}
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
@if(session('success'))
    <div style="background:#d4edda;color:#155724;padding:10px;border-radius:10px;margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('login.process') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="********" required>
        </div>

        <button type="submit" class="login-btn">Ingresar</button>

        <div class="extra-links">
            <p><a href="{{ url('/forgot-password') }}">¿Olvidaste tu contraseña?</a></p>
            <p>
    </p>
        </div>
        
    </form>

</div>
@endsection
