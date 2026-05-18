@extends('cpanel.app')

@section('title', 'Catálogo de Ventas - Rosas')

@section('content')

<h2 style="margin-bottom: 20px; color:#8b0000;">Catálogo de Estilos de Rosas</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 25px;">

    @foreach($estilos as $estilo)
    <div style="
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        padding-bottom: 15px;
        transition: 0.3s;
    ">

        <!-- Imagen -->
        <div style="height: 200px; overflow: hidden;">
            <img src="{{ asset('storage/rosas/' . $estilo->imagen) }}"
                 alt="{{ $estilo->nombre }}"
                 style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Información -->
        <div style="padding: 15px;">
            <h3 style="color:#c41e3a; margin-bottom: 8px; font-size: 20px;">
                {{ $estilo->nombre }}
            </h3>

            <p style="color:#333; margin-bottom: 10px;">{{ $estilo->descripcion }}</p>

            <h4 style="color:#8b0000; margin-bottom: 15px;">
                Precio por docena: <strong>${{ number_format($estilo->precio, 2) }}</strong>
            </h4>

            <!-- Botón -->
            <form action="{{ route('ventas.agregar') }}" method="POST">
                @csrf
                <input type="hidden" name="estilo_id" value="{{ $estilo->id }}">

                <button type="submit" style="
                    width: 100%;
                    padding: 12px;
                    background: #c41e3a;
                    color: white;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 16px;
                    font-weight: bold;
                    transition: 0.3s;
                ">
                    Agregar al pedido
                </button>
            </form>
        </div>
    </div>
    @endforeach

</div>

@endsection
