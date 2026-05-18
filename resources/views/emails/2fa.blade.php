@extends('emails.layout')

@section('content')

<h2>Código de verificación</h2>

<p>Usa el siguiente código para iniciar sesión:</p>

<div class="code-box">
    {{ $codigo }}
</div>

<p>Este código expira en unos minutos.</p>

@endsection