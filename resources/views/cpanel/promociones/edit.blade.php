@extends('cpanel.app')

@section('title', 'Editar Promoción')

@section('content')

<style>
    .edit-container{
        max-width:700px;
        margin:auto;
        background:white;
        padding:30px;
        border-radius:20px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
    }

    .edit-title{
        color:#c41e3a;
        font-weight:bold;
        margin-bottom:25px;
        text-align:center;
    }

    .form-label{
        font-weight:bold;
        color:#444;
        margin-bottom:8px;
    }

    .form-control{
        border-radius:12px;
        padding:12px;
        border:1px solid #ddd;
    }

    .promo-img{
        width:140px;
        height:140px;
        object-fit:cover;
        border-radius:15px;
        border:2px solid #eee;
        margin-top:10px;
    }

    .btn-save{
        background:#c41e3a;
        color:white;
        border:none;
        padding:12px 25px;
        border-radius:12px;
        font-weight:bold;
        transition:0.3s;
    }

    .btn-save:hover{
        background:#9e132d;
    }
</style>

<div class="container mt-4">

    <div class="edit-container">

        <h2 class="edit-title">
            ✏️ Editar Promoción
        </h2>

        <form action="{{ route('admin.promociones.update', $promocion->Id_promocion) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- TITULO --}}
            <div class="mb-3">
                <label class="form-label">Título</label>

                <input type="text"
                       name="titulo"
                       class="form-control"
                       value="{{ $promocion->titulo }}">
            </div>

            {{-- DESCRIPCION --}}
            <div class="mb-3">
                <label class="form-label">Descripción</label>

                <input type="text"
                       name="descripcion"
                       class="form-control"
                       value="{{ $promocion->descripcion }}">
            </div>

            {{-- DESCUENTO --}}
            <div class="mb-3">
                <label class="form-label">Descuento</label>

                <input type="number"
                       name="descuento"
                       class="form-control"
                       value="{{ $promocion->descuento }}">
            </div>

            {{-- IMAGEN ACTUAL --}}
            <div class="mb-3">

                <label class="form-label">
                    Imagen actual
                </label>

                <br>

                @if($promocion->imagen)

                    <img src="{{ asset('storage/' . $promocion->imagen) }}"
                         class="promo-img"
                         alt="Imagen promoción">

                @else

                    <p>No hay imagen registrada</p>

                @endif

            </div>

            {{-- CAMBIAR IMAGEN --}}
            <div class="mb-4">

                <label class="form-label">
                    Cambiar imagen
                </label>

                <input type="file"
                       name="imagen"
                       class="form-control">

            </div>

            <button type="submit" class="btn-save">
                💾 Guardar cambios
            </button>

        </form>

    </div>

</div>

@endsection