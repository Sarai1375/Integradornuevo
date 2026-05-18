@extends('cpanel.app')

@section('title','Editar Producto')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .edit-container{
        padding: 40px 20px;
    }

    .edit-card{

        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);

    }

    .edit-header{

        background: linear-gradient(135deg,#c4001d,#8f0015);
        color: white;
        padding: 45px;
        position: relative;

    }

    .edit-header h1{

        font-size: 42px;
        font-weight: 800;
        margin-bottom: 10px;

    }

    .edit-header p{

        margin: 0;
        font-size: 18px;
        opacity: .9;

    }

    .edit-body{
        padding: 45px;
    }

    .form-label{

        font-weight: 700;
        margin-bottom: 10px;
        color: #333;
        font-size: 18px;

    }

    .form-control,
    .form-select{

        border-radius: 18px;
        padding: 14px 18px;
        border: 1px solid #dcdcdc;
        font-size: 16px;
        transition: .3s;

    }

    .form-control:focus,
    .form-select:focus{

        border-color: #c4001d;
        box-shadow: 0 0 0 0.15rem rgba(196,0,29,.15);

    }

    textarea.form-control{
        min-height: 150px;
        resize: none;
    }

    .image-preview{

        width: 220px;
        height: 220px;
        border-radius: 20px;
        overflow: hidden;
        border: 2px dashed #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        margin-bottom: 20px;

    }

    .image-preview img{

        width: 100%;
        height: 100%;
        object-fit: cover;

    }

    .btn-save{

        background: #c4001d;
        color: white;
        border: none;
        border-radius: 16px;
        padding: 14px 30px;
        font-size: 17px;
        font-weight: 700;
        transition: .3s;

    }

    .btn-save:hover{

        background: #950015;
        transform: translateY(-2px);

    }

    .btn-cancel{

        border-radius: 16px;
        padding: 14px 30px;
        font-size: 17px;
        font-weight: 700;

    }

</style>

<div class="container edit-container">

    <a href="{{ route('productos.index') }}"
       class="btn btn-outline-danger mb-4 rounded-pill px-4">

        ⬅️ Volver

    </a>

    <div class="edit-card">

        <div class="edit-header">

            <h1>✏️ Editar Producto</h1>

            <p>
                Modifica la información del producto o actualiza su imagen.
            </p>

        </div>

        <div class="edit-body">

            <form action="{{ route('productos.update',$producto->Id_Producto) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label">
                            Nombre
                        </label>

                        <input type="text"
                               name="Nombre"
                               class="form-control"
                               value="{{ $producto->Nombre }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Precio
                        </label>

                        <input type="number"
                               step="0.01"
                               name="Precio"
                               class="form-control"
                               value="{{ $producto->Precio }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Stock
                        </label>

                        <input type="number"
                               name="Stock"
                               class="form-control"
                               value="{{ $producto->Stock }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Tipo
                        </label>

                        <select name="Insumo"
                                class="form-select"
                                required>

                            <option value="0"
                                {{ $producto->Insumo == 0 ? 'selected' : '' }}>
                                🌹 Producto
                            </option>

                            <option value="1"
                                {{ $producto->Insumo == 1 ? 'selected' : '' }}>
                                🧰 Insumo
                            </option>

                        </select>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Imagen actual
                        </label>

                        <div class="image-preview">

                            @if($producto->Imagen)

                                <img src="{{ asset('storage/'.$producto->Imagen) }}"
                                     alt="Producto">

                            @else

                                <span class="text-muted">
                                    Sin imagen
                                </span>

                            @endif

                        </div>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Cambiar imagen
                        </label>

                        <input type="file"
                               name="Imagen"
                               class="form-control"
                               accept="image/*">

                        <small class="text-muted">
                            Deja este campo vacío si no deseas cambiar la imagen.
                        </small>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Descripción
                        </label>

                        <textarea name="Descripcion"
                                  class="form-control"
                                  required>{{ $producto->Descripcion }}</textarea>

                    </div>

                </div>

                <div class="mt-5 d-flex gap-3">

                    <button type="submit"
                            class="btn-save">

                        💾 Actualizar

                    </button>

                    <a href="{{ route('productos.index') }}"
                       class="btn btn-secondary btn-cancel">

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection