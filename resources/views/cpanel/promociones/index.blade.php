@extends('cpanel.app')

@section('title', 'Promociones')

@section('content')

<style>
    .promo-container{
        background:#f4f4f4;
        padding:25px;
        border-radius:20px;
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        position:relative;
    }

    .btn-close{
        position:absolute;
        top:20px;
        right:20px;
        width:50px;
        height:50px;
        border-radius:50%;
        background:#c41e3a;
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        text-decoration:none;
        font-size:28px;
        font-weight:bold;
        box-shadow:0 4px 10px rgba(0,0,0,0.2);
        transition:0.3s;
    }

    .btn-close:hover{
        background:#9e132d;
        transform:scale(1.05);
    }

    .promo-title{
        color:#c41e3a;
        margin-bottom:10px;
        font-size:30px;
        font-weight:bold;
    }

    .promo-subtitle{
        color:#555;
        margin-bottom:25px;
    }

    .btn-new{
        display:inline-block;
        background:#16a34a;
        color:white;
        padding:12px 22px;
        border-radius:12px;
        text-decoration:none;
        font-weight:bold;
        margin-bottom:25px;
        transition:0.3s;
        box-shadow:0 3px 10px rgba(0,0,0,0.1);
    }

    .btn-new:hover{
        background:#15803d;
        transform:translateY(-2px);
    }

    .table-wrapper{
        background:white;
        border-radius:20px;
        padding:20px;
        overflow-x:auto;
        box-shadow:0 4px 15px rgba(0,0,0,0.05);
    }

    .promo-table{
        width:100%;
        border-collapse:separate;
        border-spacing:0 15px;
    }

    .promo-table thead tr{
        background:#b3001b;
        color:white;
    }

    .promo-table th{
        padding:16px;
        text-align:left;
        font-size:15px;
    }

    .promo-table tbody tr{
        background:#fafafa;
        box-shadow:0 2px 8px rgba(0,0,0,0.05);
        transition:0.3s;
    }

    .promo-table tbody tr:hover{
        transform:scale(1.01);
        background:#fff;
    }

    .promo-table td{
        padding:18px 14px;
        vertical-align:middle;
    }

    .badge-activa{
        background:#16a34a;
        color:white;
        padding:8px 14px;
        border-radius:20px;
        font-size:13px;
        font-weight:bold;
    }

    .badge-inactiva{
        background:#dc2626;
        color:white;
        padding:8px 14px;
        border-radius:20px;
        font-size:13px;
        font-weight:bold;
    }

    .promo-img{
        width:70px;
        height:70px;
        object-fit:cover;
        border-radius:12px;
        border:2px solid #eee;
    }

    .discount{
        color:#c41e3a;
        font-weight:bold;
        font-size:17px;
    }

    .empty-row{
        text-align:center;
        padding:30px;
        color:#666;
        font-weight:bold;
    }

    /* BOTONES ACCIONES */
    .btn-edit{
        background:#f59e0b;
        color:white;
        padding:6px 10px;
        border-radius:8px;
        text-decoration:none;
        font-size:13px;
        margin-right:5px;
    }

    .btn-delete{
        background:#dc2626;
        color:white;
        padding:6px 10px;
        border-radius:8px;
        border:none;
        font-size:13px;
        cursor:pointer;
    }

    .actions{
        display:flex;
        align-items:center;
        gap:6px;
    }
</style>

<div class="promo-container">

    <a href="{{ route('bienvenido') }}" class="btn-close">✕</a>

    <h2 class="promo-title">
        🌹 Promociones de Rosas por Mayoreo
    </h2>

    <p class="promo-subtitle">
        Consulta y administra las promociones registradas en el sistema.
    </p>

    <a href="{{ route('admin.promociones.create') }}" class="btn-new">
        ➕ Nueva promoción
    </a>

    <div class="table-wrapper">

        <table class="promo-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Descuento</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @forelse($promociones as $promo)

                    <tr>

                        <td><strong>#{{ $promo->Id_promocion }}</strong></td>
                        <td>{{ $promo->titulo ?? 'Sin título' }}</td>
                        <td>{{ $promo->descripcion ?? 'Sin descripción' }}</td>
                        <td class="discount">{{ $promo->descuento }}%</td>
                        <td>{{ $promo->fecha_inicio }}</td>
                        <td>{{ $promo->fecha_fin }}</td>

                        <td>
                            @if($promo->estado == 'activa')
                                <span class="badge-activa">Activa</span>
                            @else
                                <span class="badge-inactiva">Inactiva</span>
                            @endif
                        </td>

                        <td>
                            @if($promo->imagen)
                                <img src="{{ asset('storage/' . $promo->imagen) }}"
                                     class="promo-img">
                            @else
                                Sin imagen
                            @endif
                        </td>

                        <td>{{ $promo->Id_Producto }}</td>

                        {{-- 🔥 ACCIONES AGREGADAS --}}
                        <td class="actions">

                            <a href="{{ route('admin.promociones.edit', $promo->Id_promocion) }}"
                               class="btn-edit">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('admin.promociones.delete', $promo->Id_promocion) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar esta promoción?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">
                                    🗑️
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10" class="empty-row">
                            No hay promociones registradas
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection