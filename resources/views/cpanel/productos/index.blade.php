@extends('cpanel.app')

@section('title','Productos')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .products-container{
        padding: 35px;
    }

    /* BOTÓN CERRAR (NUEVO ESTILO) */

    .btn-close-admin{

        width: 45px;
        height: 45px;
        background: white;
        color: #8b0000;
        border-radius: 50%;
        border: 2px solid #8b0000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: 0.3s;
    }

    .btn-close-admin:hover{
        background: #8b0000;
        color: white;
        transform: scale(1.1);
    }

    /* HEADER */

    .products-header{

        background: linear-gradient(135deg, #8b0000, #c40000);
        padding: 35px;
        border-radius: 30px;
        color: white;
        margin-top: 20px;
        margin-bottom: 35px;
        position: relative;
        overflow: hidden;

    }

    .products-header::before{

        content: "🌹";
        position: absolute;
        right: 25px;
        top: 10px;
        font-size: 90px;
        opacity: 0.15;

    }

    .products-title{
        font-size: 2.3rem;
        font-weight: bold;
    }

    .products-subtitle{
        opacity: 0.9;
        margin-top: 10px;
    }

    .top-actions{
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .btn-custom{

        padding: 12px 22px;
        border-radius: 15px;
        border: none;
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;

    }

    .btn-custom:hover{
        transform: translateY(-2px);
        color: white;
    }

    .btn-add{ background: #198754; }
    .btn-report{ background: #0d6efd; }
    .btn-excel{ background: #146c43; }

    .products-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .product-card{
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .product-card:hover{
        transform: translateY(-5px);
    }

    .product-image{
        width: 100%;
        height: 250px;
        object-fit: cover;
        background: #eee;
    }

    .product-body{ padding: 25px; }

    .product-name{
        font-size: 1.4rem;
        font-weight: bold;
        color: #8b0000;
        margin-bottom: 10px;
    }

    .product-description{
        color: #555;
        min-height: 60px;
        margin-bottom: 20px;
    }

    .product-info{
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .price{
        color: #198754;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .stock{
        color: #444;
        font-weight: 600;
    }

    .badge-insumo{
        background: #ffc107;
        color: #222;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .badge-producto{
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .card-actions{
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-edit,
    .btn-delete{
        flex: 1;
        text-align: center;
        padding: 10px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-edit{ background: #0d6efd; color: white; }
    .btn-delete{ background: #dc3545; color: white; border: none; }

    .btn-edit:hover,
    .btn-delete:hover{
        transform: scale(1.03);
        color: white;
    }

    .empty-box{
        background: white;
        border-radius: 20px;
        padding: 50px;
        text-align: center;
        color: #666;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

</style>

<div class="products-container">

    <!-- BOTÓN VOLVER (AHORA MÁS BONITO Y FLOTANTE) -->
    <div style="display:flex; justify-content:flex-end; margin-bottom:15px;">

        <a href="{{ route('bienvenido') }}"
           class="btn-close-admin"
           title="Volver">

            ✕

        </a>

    </div>

    <!-- HEADER -->

    <div class="products-header">

        <h1 class="products-title">
            🌹 Gestión de Productos
        </h1>

        <p class="products-subtitle">
            Administra rosas, insumos y productos disponibles del sistema.
        </p>

    </div>

    <!-- BOTONES -->

    <div class="top-actions">

        <a href="{{ route('productos.create') }}"
           class="btn-custom btn-add">

            ➕ Agregar Producto

        </a>

    </div>

    <!-- PRODUCTOS -->

    @if(isset($productos) && count($productos) > 0)

        <div class="products-grid">

            @foreach($productos as $producto)

                <div class="product-card">

                    @if($producto->Imagen)
                        <img src="{{ asset('storage/'.$producto->Imagen) }}"
                             class="product-image">
                    @else
                        <img src="{{ asset('images/rosa.jpg') }}"
                             class="product-image">
                    @endif

                    <div class="product-body">

                        @if($producto->Insumo == 1)
                            <span class="badge-insumo">🧰 Insumo</span>
                        @else
                            <span class="badge-producto">🌹 Producto</span>
                        @endif

                        <div class="product-name">{{ $producto->Nombre }}</div>

                        <div class="product-description">{{ $producto->Descripcion }}</div>

                        <div class="product-info">
                            <div class="price">${{ $producto->Precio }}</div>
                            <div class="stock">Stock: {{ $producto->Stock }}</div>
                        </div>

                        <div class="card-actions">

                            <a href="{{ route('productos.edit', $producto->Id_Producto) }}"
                               class="btn-edit">✏️ Editar</a>

                            <form action="{{ route('productos.destroy', $producto->Id_Producto) }}"
                                  method="POST"
                                  style="flex:1;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('¿Deseas eliminar este producto?')"
                                        class="btn-delete"
                                        style="width:100%;">

                                    🗑️ Eliminar

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-box">
            <h3>No hay productos registrados</h3>
            <p>Agrega productos para comenzar.</p>
        </div>

    @endif

</div>

@endsection