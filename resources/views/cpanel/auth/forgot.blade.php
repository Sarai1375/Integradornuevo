@extends('cpanel.app')

@section('title','Recuperar contraseña')

@section('content')

<style>

.page-wrapper{
    max-width: 600px;
    margin: auto;
}

.card-reset{
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-top: 30px;
}
.btn-close-custom {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 24px;
    text-decoration: none;
    color: #333;
    background: #f2f2f2;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 0.2s;
}

.btn-close-custom:hover {
    background: #ddd;
    color: #000;
}

.header-reset{
    background: linear-gradient(135deg, #8b0000, #c40000);
    color: white;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    position: relative;
}

.header-reset::before{
    content: "🔐";
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 60px;
    opacity: 0.2;
}

.input-box{
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin-top: 10px;
    outline: none;
}

.input-box:focus{
    border-color: #b30000;
    box-shadow: 0 0 5px rgba(179,0,0,0.3);
}

.btn-reset{
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    border: none;
    border-radius: 25px;
    background: #b30000;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-reset:hover{
    background: #8c0000;
}

.alert-success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:10px;
    margin-top:15px;
}

.alert-error{
    background:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:10px;
    margin-top:15px;
}

.helper-text{
    font-size: 13px;
    color: #777;
    margin-top: 10px;
    text-align: center;
}

</style>

<div class="page-wrapper">


    <div class="header-reset">
        <a href="{{ route('login') }}" class="btn-close-custom">×</a>
        <h2>Recuperar contraseña</h2>
        <p>Ingresa tu correo para enviarte una nueva contraseña</p>
    </div>

    <div class="card-reset">

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- FORM --}}
        <form method="POST" action="{{ route('password.reset') }}">
            @csrf

            <label>Correo electrónico</label>
            <input type="email" name="Email" class="input-box" placeholder="ejemplo@gmail.com" required>

            <button type="submit" class="btn-reset">
                Enviar nueva contraseña
            </button>

            <div class="helper-text">
                Te enviaremos una contraseña nueva a tu correo registrado.
            </div>
        </form>

    </div>

</div>

@endsection