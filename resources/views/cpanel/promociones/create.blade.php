@extends('cpanel.app')

@section('title', 'Crear Promoción')

@section('content')

<div class="container mt-4">

    <h2 style="color:#c41e3a; margin-bottom:20px;">
        ➕ 
    </h2>

    <form action="{{ route('admin.promociones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- TÍTULO --}}
        <div style="margin-bottom:15px;">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        {{-- DESCRIPCIÓN --}}
        <div style="margin-bottom:15px;">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        {{-- DESCUENTO --}}
        <div style="margin-bottom:15px;">
            <label>Descuento (%)</label>
            <input type="number" name="descuento" class="form-control" min="1" max="100" required>
        </div>

        {{-- FECHA INICIO --}}
        <div style="margin-bottom:15px;">
            <label>Fecha de inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        {{-- FECHA FIN --}}
        <div style="margin-bottom:15px;">
            <label>Fecha de fin</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>

        {{-- ESTADO --}}
        <div style="margin-bottom:15px;">
            <label>Estado</label>
            <select name="estado" class="form-control">
                <option value="activa">Activa</option>
                <option value="inactiva">Inactiva</option>
            </select>
        </div>

        {{-- IMAGEN --}}
        <div style="margin-bottom:15px;">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        {{-- PRODUCTO (BD REAL) --}}
        <div style="margin-bottom:15px;">
            <label>Producto relacionado</label>

            <select name="Id_Producto" class="form-control" required>
                <option value="">-- Selecciona un producto --</option>

                @foreach($productos as $producto)
                    <option value="{{ $producto->Id_Producto }}">
                        {{ $producto->Nombre ?? 'Sin nombre' }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- BOTONES --}}
        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-success">
                Guardar promoción
            </button>

            <a href="{{ route('admin.promociones') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection