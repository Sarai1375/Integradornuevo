@extends('cliente.app')

@section('title', 'Inicio Cliente')

@push('styles')
<style>

    .hero{
        background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                    url('/images/inverna.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        padding: 90px 40px;
        color: white;
        text-align: center;
        margin-bottom: 40px;
    }

    .hero h1{
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p{
        font-size: 1.2rem;
        max-width: 700px;
        margin: auto;
    }

    .welcome-box{
        background: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .section-title{
        color: #8b0000;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .card-product{
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .card-product:hover{
        transform: translateY(-5px);
    }

    .card-product img{
        height: 220px;
        object-fit: cover;
    }

    .price{
        color: #8b0000;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .btn-buy{
        background: #8b0000;
        color: white;
        border-radius: 10px;
    }
 .btn-buy:hover{
        background: #b1122d;
        color: white;
    }

    .promo-box{
        background: linear-gradient(135deg, #ffe5e5, #fff0f0);
        padding: 20px;
        border-radius: 15px;
        margin-top: 40px;
        border-left: 5px solid #8b0000;
    }

</style>
@endpush

@section('content')

<div class="welcome-box">

    <h2>
        Hola, {{ session('nombre') }} 🌹
    </h2>

    <p>
        Bienvenido nuevamente a Invernaderos Javier Domínguez.
        Descubre nuestras rosas más frescas y promociones especiales.
    </p>

</div>

<div class="hero">

    <h1>Rosas frescas directo del invernadero</h1>

    <p>
        Calidad premium para floristas, decoradores y negocios.
    </p>

</div>

<h2 class="section-title">🌹 Catálogo de Rosas</h2>

<div class="row">

    @forelse($productos as $producto)

        <div class="col-md-4 mb-4">

            <div class="card card-product">

                {{-- IMAGEN --}}

                @if($producto->Imagen)

                    <img src="{{ asset('storage/'.$producto->Imagen) }}">

                @else

                    <img src="{{ asset('images/inverna.jpg') }}">

                @endif

                <div class="card-body text-center">

                    <h5>
                        {{ $producto->Nombre }}
                    </h5>

                    <p class="price">
                        ${{ $producto->Precio }}
                    </p>

                    <p>
                        {{ $producto->Descripcion }}
                    </p>

             <form action="{{ route('carrito.agregar', $producto->Id_Producto) }}"
                    method="POST">

                @csrf
                <button type="submit"
                class="btn btn-buy w-100">
                     Agregar al carrito

                </button>

            </form>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-warning">

                No hay productos disponibles.

            </div>

        </div>

    @endforelse

</div>


@endsection