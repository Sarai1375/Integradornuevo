@extends('cliente.app')

@section('title', 'Mis Pedidos')

@section('content')

<div class="container bg-white p-5 rounded shadow-sm">

    <h2 class="text-danger mb-4">
        📦 Mis pedidos
    </h2>

    <div class="table-responsive">

        <table class="table table-hover table-bordered align-middle">

            <thead class="table-danger text-center">

                <tr>
                    <th># Pedido</th>
                    <th>Fecha realizada</th>
                    <th>Fecha entrega</th>
                    <th>Paquetes</th>
                    <th>Tipo entrega</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($pedidos as $pedido)

                    <tr class="text-center">

                        <td>#{{ $pedido->Id_ped }}</td>

                        <td>{{ $pedido->Fecha_realizada }}</td>

                        <td>{{ $pedido->Fecha_entrega }}</td>

                        <td>{{ $pedido->Cantidad_paquetes }}</td>

                        <td>
                            @if($pedido->Tipo_entrega == 'Domicilio')
                                <span class="badge bg-primary">🚚 Domicilio</span>
                            @else
                                <span class="badge bg-secondary">🏪 Sucursal</span>
                            @endif
                        </td>

                        <td>
                            ${{ number_format($pedido->Total_pedido, 2) }}
                        </td>

                        <td>
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
                        </td>

                        <td>
                            <a href="{{ route('cliente.pedidos.detalle', $pedido->Id_ped) }}"
                               class="btn btn-sm btn-outline-danger">
                                Ver detalle
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center py-4">
                            No tienes pedidos aún 🌹
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection