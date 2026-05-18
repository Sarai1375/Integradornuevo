@extends('cpanel.app')
@section('title', 'Verificación 2FA')

@section('content')
<div class="container">
    <h2>Ingresa el código de verificación</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="color: red;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('twofactor.verify') }}">
        @csrf
        <input type="text" name="code" placeholder="Código de 6 dígitos" required>
        <button type="submit">Verificar</button>
    </form>

    <form method="POST" action="{{ route('twofactor.send') }}">
        @csrf
        <button type="submit">Reenviar código</button>
    </form>
</div>
@endsection
