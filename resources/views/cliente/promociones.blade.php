@extends('cliente.app')

@section('title', 'Promociones')

@section('content')
<div class="container py-5">

    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-danger">Promociones Especiales</h1>
        <p class="text-muted">
            Aprovecha nuestras ofertas en rosas por mayoreo para floristas,
            decoradores y negocios.
        </p>
    </div>

<!-- Promociones -->
        <div class="row g-4">

        @forelse($promociones as $promo)
            <div class="col-md-4">

                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">

                    <!-- IMAGEN -->
                    <img src="{{ $promo->imagen 
                            ? asset('storage/' . $promo->imagen) 
                            : asset('img/promo-default.jpg') }}"
                        class="card-img-top"
                        alt="Promoción"
                        style="height: 250px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">

                        <!-- TÍTULO -->
                        <h4 class="fw-bold text-danger">
                            {{ $promo->titulo }}
                        </h4>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-muted flex-grow-1">
                            {{ $promo->descripcion }}
                        </p>

                        <!-- PRECIOS -->
                        @php
                            $precioOriginal = $promo->precio_original ?? 0;
                            $descuento = $promo->descuento ?? 0;
                            $precioFinal = $precioOriginal - ($precioOriginal * $descuento / 100);
                        @endphp

                        <div class="mb-3">

                            <span class="text-decoration-line-through text-secondary">
                                ${{ number_format($precioOriginal, 2) }}
                            </span>

                            <h3 class="text-success fw-bold">
                                ${{ number_format($precioFinal, 2) }}
                            </h3>

                            <small class="text-muted">
                                {{ $descuento }}% de descuento aplicado
                            </small>

                        </div>

                        <!-- VIGENCIA -->
                        <p class="small text-muted">
                            Vigencia:
                            <strong>
                                {{ \Carbon\Carbon::parse($promo->fecha_inicio)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($promo->fecha_fin)->format('d/m/Y') }}
                            </strong>
                        </p>

                        <!-- ESTADO -->
                        <p class="small">
                            <span class="badge bg-{{ $promo->estado == 'activa' ? 'success' : 'secondary' }}">
                                {{ ucfirst($promo->estado) }}
                            </span>
                        </p>

                        <!-- BOTÓN CARRITO -->
                        <form action="{{ route('cliente.carrito', $promo->Id_Producto) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-danger w-100">
                                Agregar al carrito
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center">
                <div class="alert alert-warning rounded-4 shadow-sm">
                    No hay promociones disponibles por el momento.
                </div>
            </div>
        @endforelse

        </div>
</div>
@endsection