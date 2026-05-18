@extends('cpanel.app')

@section('title','Crear Producto')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .product-container{
        padding: 35px;
    }

    .product-card{

        background: white;
        border-radius: 30px;
        padding: 45px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);

    }

    /* BOTÓN REGRESAR */

    .btn-back{

        background: white;
        color: #8b0000;
        border: 2px solid #8b0000;
        padding: 12px 22px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
        display: inline-block;

    }

    .btn-back:hover{

        background: #8b0000;
        color: white;

    }

    /* HEADER */

    .header-box{

        background: linear-gradient(135deg,#8b0000,#c40000);
        border-radius: 25px;
        padding: 35px;
        color: white;
        margin-top: 20px;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;

    }

    .header-box::before{

        content: "🌹";
        position: absolute;
        right: 25px;
        top: 10px;
        font-size: 90px;
        opacity: 0.15;

    }

    .header-title{

        font-size: 2.2rem;
        font-weight: bold;

    }

    .header-subtitle{

        margin-top: 10px;
        opacity: 0.9;

    }

    /* GRID */

    .form-grid{

        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 25px;

    }

    .full-width{
        grid-column: span 2;
    }

    .form-group{
        display: flex;
        flex-direction: column;
    }

    .form-label{

        font-weight: 600;
        margin-bottom: 8px;
        color: #444;

    }

    .form-control,
    .form-select{

        border-radius: 15px;
        padding: 14px;
        border: 1px solid #ddd;
        transition: 0.3s;

    }

    .form-control:focus,
    .form-select:focus{

        border-color: #8b0000;
        box-shadow: 0 0 0 0.15rem rgba(139,0,0,0.2);

    }

    textarea.form-control{
        min-height: 130px;
        resize: none;
    }

    /* BOTONES */

    .buttons{

        margin-top: 35px;
        display: flex;
        justify-content: center;
        gap: 20px;

    }

    .btn-save{

        background: linear-gradient(135deg,#8b0000,#c40000);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 15px;
        font-weight: 600;
        transition: 0.3s;

    }

    .btn-save:hover{

        transform: translateY(-2px);

    }

    .btn-cancel{

        background: white;
        color: #6c757d;
        border: 2px solid #6c757d;
        padding: 14px 28px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 600;

    }

    .btn-cancel:hover{

        background: #6c757d;
        color: white;

    }

    @media(max-width:768px){

        .form-grid{
            grid-template-columns: 1fr;
        }

        .full-width{
            grid-column: span 1;
        }

    }

</style>

<div class="product-container">

    <!-- REGRESAR -->

    <a href="{{ route('productos.index') }}"
       class="btn-back">

        ⬅️ Volver a Productos

    </a>

    <!-- CARD -->

    <div class="product-card">

        <!-- HEADER -->

        <div class="header-box">

            <div class="header-title">
                ➕ Crear Producto
            </div>

            <div class="header-subtitle">
                Agrega nuevos productos o insumos al sistema.
            </div>

        </div>

        <!-- FORM -->

        <form action="{{ route('productos.store') }}"
      method="POST"
      enctype="multipart/form-data">

            @csrf

            <div class="form-grid">

                <!-- NOMBRE -->

                <div class="form-group">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input type="text"
                           name="Nombre"
                           class="form-control"
                           required>

                </div>

                <!-- PRECIO -->

                <div class="form-group">

                    <label class="form-label">
                        Precio
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="Precio"
                           class="form-control"
                           required>

                </div>

                <!-- STOCK -->

                <div class="form-group">

                    <label class="form-label">
                        Stock
                    </label>

                    <input type="number"
                           min="0"
                           name="Stock"
                           class="form-control"
                           required>

                </div>

                <!-- TIPO -->

                <div class="form-group">

                    <label class="form-label">
                        Tipo
                    </label>

                    <select name="Insumo"
                            class="form-select"
                            required>

                        <option value="">
                            -- Selecciona --
                        </option>

                        <option value="0">
                            🌹 Producto
                        </option>

                        <option value="1">
                            🧰 Insumo
                        </option>

                    </select>

                </div>

                <!-- IMAGEN -->

                <div class="form-group full-width">

                    <label class="form-label">
                        Imagen (URL o nombre)
                    </label>

                    <input type="file"
                        name="Imagen"
                        class="form-control"
                        accept="image/*">

                </div>

                <!-- DESCRIPCIÓN -->

                <div class="form-group full-width">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea name="Descripcion"
                              class="form-control"
                              required></textarea>

                </div>

            </div>

            <!-- BOTONES -->

            <div class="buttons">

                <button type="submit"
                        class="btn-save">

                    💾 Guardar Producto

                </button>

                <a href="{{ route('productos.index') }}"
                   class="btn-cancel">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

@endsection