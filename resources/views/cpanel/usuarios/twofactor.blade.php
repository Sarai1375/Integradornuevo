@extends('cpanel.app')
@section('title', 'Verificación 2FA')

@section('content')
<div class="container">
    <h2>Verificación en 2 pasos</h2>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('twofactor.verify') }}" style="margin-bottom: 15px;">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="code" style="display:block; font-weight:bold; margin-bottom:5px;">Código de 6 dígitos</label>
            <input type="text" id="code" name="code" placeholder="Ingresa tu código"
                   style="width:100%; padding:8px; border:1px solid #ced4da; border-radius:5px;">
        </div>
        <button type="submit" 
                style="padding: 8px 15px; background-color: #007bff; color: white; border-radius: 5px; border:none; cursor:pointer;">
            Verificar
        </button>
    </form>

    <form method="POST" action="{{ route('twofactor.send') }}">
        @csrf
        <button type="submit" 
                style="padding: 8px 15px; background-color: #6c757d; color: white; border-radius: 5px; border:none; cursor:pointer;">
            Reenviar código
        </button>
    </form>
    
</div>
@endsection
