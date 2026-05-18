@extends('cpanel.app')

@section('title', 'Gestión de Pedidos')

@section('content')

<div class="container-fluid py-4 px-4 position-relative">

    {{-- BOTÓN CERRAR --}}
    <a href="{{ route('bienvenido') }}" class="btn-cerrar">
        ✕
    </a>

    {{-- TÍTULO --}}
    <div class="mb-4">
        <h2 class="titulo-pedidos">🌹 Gestión de pedidos</h2>

        <p class="subtitulo-pedidos">
            Administra pedidos, valida transferencias y actualiza estados.
        </p>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alerta-personalizada">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alerta-personalizada">
            {{ session('error') }}
        </div>
    @endif

    {{-- TABLA --}}
    <div class="tabla-contenedor">

        <div class="table-responsive">

            <table class="table tabla-pedidos align-middle">

                <thead>
                    <tr>
                        <th># Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Comprobante</th>
                        <th style="min-width:200px;">Cambiar estado</th>
                        <th style="min-width:150px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pedidos as $pedido)

                    <tr>

                        {{-- ID --}}
                        <td class="fw-bold numero-pedido">
                            #{{ $pedido->Id_ped }}
                        </td>

                        {{-- CLIENTE --}}
                        <td>
                            <div class="cliente-info">
                                <span class="cliente-nombre">
                                    {{ $pedido->Nombre }}
                                    {{ $pedido->Ape_pat }}
                                </span>
                            </div>
                        </td>

                        {{-- FECHA --}}
                        <td>
                            {{ $pedido->Fecha_entrega }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="fw-bold total-pedido">
                            ${{ number_format($pedido->Total_pedido, 2) }}
                        </td>

                        {{-- ESTADO --}}
                        <td>

                            @if($pedido->Estado_pedido == 'Pendiente')
                                <span class="badge-soft warning">
                                    Pendiente
                                </span>

                            @elseif($pedido->Estado_pedido == 'Confirmado')
                                <span class="badge-soft info">
                                    Confirmado
                                </span>

                            @elseif($pedido->Estado_pedido == 'Enviado')
                                <span class="badge-soft primary">
                                    Enviado
                                </span>

                            @elseif($pedido->Estado_pedido == 'Entregado')
                                <span class="badge-soft success">
                                    Entregado
                                </span>

                            @elseif($pedido->Estado_pedido == 'Cancelado')
                                <span class="badge-soft danger">
                                    Cancelado
                                </span>
                            @endif

                        </td>

                        {{-- COMPROBANTE --}}
                        <td>

                            @if($pedido->Comprobante)

                                <a href="{{ asset($pedido->Comprobante) }}"
                                   target="_blank">

                                    <img src="{{ asset($pedido->Comprobante) }}"
                                         class="img-comprobante">

                                </a>

                            @else

                                <span class="sin-comprobante">
                                    Sin comprobante
                                </span>

                            @endif

                        </td>

                        {{-- CAMBIAR ESTADO --}}
                        <td>

                            <form action="{{ route('admin.pedidos.estado', $pedido->Id_ped) }}"
                                  method="POST"
                                  class="d-flex gap-2">

                                @csrf

                                <select name="Estado_pedido"
                                        class="form-select form-select-sm select-rosa">

                                    <option value="Pendiente"
                                        {{ $pedido->Estado_pedido == 'Pendiente' ? 'selected' : '' }}>
                                        Pendiente
                                    </option>

                                    <option value="Confirmado"
                                        {{ $pedido->Estado_pedido == 'Confirmado' ? 'selected' : '' }}>
                                        Confirmado
                                    </option>

                                    <option value="Enviado"
                                        {{ $pedido->Estado_pedido == 'Enviado' ? 'selected' : '' }}>
                                        Enviado
                                    </option>

                                    <option value="Entregado"
                                        {{ $pedido->Estado_pedido == 'Entregado' ? 'selected' : '' }}>
                                        Entregado
                                    </option>

                                    <option value="Cancelado"
                                        {{ $pedido->Estado_pedido == 'Cancelado' ? 'selected' : '' }}>
                                        Cancelado
                                    </option>

                                </select>

                        </td>

                        {{-- BOTÓN --}}
                        <td>

                                <button type="submit"
                                        class="btn btn-rosa btn-sm w-100">
                                    Actualizar
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="sin-pedidos">
                            No hay pedidos registrados 🌹
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- ESTILOS --}}
<style>

body{
    background:#fff7f9;
}

/* BOTÓN CERRAR */
.btn-cerrar{
    position:fixed;
    top:120px;
    right:25px;
    z-index:999;

    width:45px;
    height:45px;

    border-radius:50%;

    background:linear-gradient(135deg,#b3122f,#e63956);

    color:white;
    text-decoration:none;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:20px;
    font-weight:bold;

    box-shadow:0 5px 15px rgba(179,18,47,0.3);

    transition:0.3s;
}

.btn-cerrar:hover{
    transform:scale(1.08);
    color:white;
    background:linear-gradient(135deg,#8f1027,#cc2343);
}

/* TÍTULOS */
.titulo-pedidos{
    color:#b3122f;
    font-size:32px;
    font-weight:700;
    margin-bottom:5px;
}

.subtitulo-pedidos{
    color:#7c4b57;
    font-size:15px;
}

/* ALERTAS */
.alerta-personalizada{
    border:none;
    border-radius:15px;
    padding:14px;
    font-weight:500;
}

/* CONTENEDOR */
.tabla-contenedor{
    background:white;
    border-radius:24px;
    padding:25px;
    border:2px solid #f5e8ec;

    box-shadow:0 10px 30px rgba(179,18,47,0.08);
}

/* TABLA */
.tabla-pedidos{
    border-collapse:separate;
    border-spacing:0;
    width:100%;
    overflow:hidden;
    border-radius:18px;
}

/* HEAD */
.tabla-pedidos thead{
    background:linear-gradient(135deg,#a60f2d,#d7264d);
}

.tabla-pedidos thead th{
    color:white;
    padding:18px;
    font-size:14px;
    font-weight:600;
    text-align:center;
    border:1px solid rgba(255,255,255,0.12);
}

/* FILAS */
.tabla-pedidos tbody tr{
    background:white;
    transition:0.2s;
}

.tabla-pedidos tbody tr:hover{
    background:#fff1f4;
}

/* CELDAS */
.tabla-pedidos tbody td{
    padding:16px;
    border:1px solid #f4e7eb;
    vertical-align:middle;
    text-align:center;
    font-size:14px;
}

/* TEXTOS */
.numero-pedido{
    color:#c1123f;
    font-size:15px;
}

.total-pedido{
    color:#198754;
    font-size:15px;
}

.cliente-nombre{
    font-weight:600;
    color:#5c2432;
}

/* SELECT */
.select-rosa{
    border-radius:12px;
    border:2px solid #d7264d;
    min-width:150px;
}

.select-rosa:focus{
    border-color:#a60f2d;
    box-shadow:0 0 0 0.15rem rgba(215,38,77,0.2);
}

/* BOTÓN */
.btn-rosa{
    background:linear-gradient(135deg,#b3122f,#e63956);
    border:none;
    color:white;
    border-radius:12px;
    padding:8px 15px;
    font-weight:600;

    transition:0.25s;

    box-shadow:0 4px 10px rgba(179,18,47,0.2);
}

.btn-rosa:hover{
    color:white;
    transform:translateY(-2px);

    background:linear-gradient(135deg,#8f1027,#cc2343);
}

/* BADGES */
.badge-soft{
    padding:8px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

/* ESTADOS */
.badge-soft.warning{
    background:#fff3cd;
    color:#856404;
}

.badge-soft.info{
    background:#d9ecff;
    color:#0c4a6e;
}

.badge-soft.primary{
    background:#eadcff;
    color:#5b21b6;
}

.badge-soft.success{
    background:#d1fae5;
    color:#065f46;
}

.badge-soft.danger{
    background:#ffe2e2;
    color:#991b1b;
}

/* COMPROBANTE */
.img-comprobante{
    width:75px;
    height:75px;
    object-fit:cover;

    border-radius:14px;
    border:2px solid #f2dbe1;

    transition:0.2s;
}

.img-comprobante:hover{
    transform:scale(1.05);
}

.sin-comprobante{
    color:#9b6c77;
    font-size:13px;
}

/* SIN PEDIDOS */
.sin-pedidos{
    padding:35px !important;
    color:#8c6670;
    font-weight:500;
    text-align:center;
}

</style>

@endsection