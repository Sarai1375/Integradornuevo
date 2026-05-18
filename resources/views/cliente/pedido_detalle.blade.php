@extends('cliente.app')

@section('title', 'Detalle del Pedido')

@section('content')

<div class="container bg-white p-5 rounded shadow-sm">

    <h2 class="text-danger mb-4">
        📦 Pedido #{{ $pedido->Id_ped }}
    </h2>

    {{-- INFORMACIÓN GENERAL --}}
    <div class="row mb-4">

        <div class="col-md-6">

            <p><strong>Fecha realizada:</strong> {{ $pedido->Fecha_realizada }}</p>
            <p><strong>Fecha entrega:</strong> {{ $pedido->Fecha_entrega }}</p>
            <p><strong>Tipo entrega:</strong> {{ $pedido->Tipo_entrega }}</p>

            <p><strong>Estado:</strong>

                @if($pedido->Estado_pedido == 'Pendiente')
                    <span class="badge bg-warning text-dark">⏳ Pendiente</span>
                @elseif($pedido->Estado_pedido == 'Confirmado')
                    <span class="badge bg-info text-dark">✔ Confirmado</span>
                @elseif($pedido->Estado_pedido == 'Enviado')
                    <span class="badge bg-primary">🚚 Enviado</span>
                @elseif($pedido->Estado_pedido == 'Entregado')
                    <span class="badge bg-success">🌹 Entregado</span>
                @elseif($pedido->Estado_pedido == 'Cancelado')
                    <span class="badge bg-danger">❌ Cancelado</span>
                @endif

            </p>

        </div>

        <div class="col-md-6">

            <p><strong>Total del pedido:</strong>
                ${{ number_format($pedido->Total_pedido, 2) }}
            </p>

            <p><strong>Paquetes:</strong> {{ $pedido->Cantidad_paquetes }}</p>

            <p><strong>Dirección:</strong> {{ $pedido->Direccion_entrega }}</p>

            <p><strong>Observaciones:</strong>
                {{ $pedido->Observaciones ?? 'Sin observaciones' }}
            </p>

        </div>

    </div>

    <hr>

    {{-- PRODUCTOS --}}
    <h4 class="text-danger mb-3">🌹 Productos del pedido</h4>

    <div class="table-responsive">

        <table class="table table-bordered table-hover text-center align-middle">

            <thead class="table-danger">

                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>

            </thead>

            <tbody>

                @foreach($productos as $p)

                    <tr>
                        <td>{{ $p->Nombre }}</td>
                        <td>{{ $p->Cantidad }}</td>
                        <td>${{ number_format($p->Precio_unitario, 2) }}</td>
                        <td>${{ number_format($p->Subtotal, 2) }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="text-end mt-3">

        <h5>
            💰 Total: ${{ number_format($pedido->Total_pedido, 2) }}
        </h5>

    </div>

</div>

@endsection