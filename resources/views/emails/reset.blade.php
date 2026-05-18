@extends('emails.layout')

@section('content')

<h2>Hola {{ $nombre }}</h2>

<p>Has solicitado recuperar tu contraseña.</p>

<p>Tu nueva contraseña es:</p>

<div class="code-box">
    {{ $password }}
</div>

<p>Te recomendamos cambiarla después de iniciar sesión.</p>


@endsection