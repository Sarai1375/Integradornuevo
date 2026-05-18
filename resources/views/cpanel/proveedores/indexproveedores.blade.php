@extends('cpanel.app')
@section('title','Proveedores')

@section('content')

<div class="container py-4">

    {{-- ENCABEZADO --}}
    <div style="
        background: linear-gradient(135deg, #c53030, #e53e3e);
        padding: 20px 25px;
        border-radius: 18px 18px 0 0;
        display:flex;
        justify-content:space-between;
        align-items:center;
        box-shadow:0 6px 15px rgba(0,0,0,0.10);
    ">

        {{-- TÍTULO --}}
        <div>
            <h2 style="
                color:white;
                font-weight:700;
                margin:0;
            ">
                📦 Lista de Proveedores
            </h2>

            <p style="
                color:#ffe5e5;
                margin:0;
                margin-top:5px;
            ">
                Administración de proveedores registrados
            </p>
        </div>

        {{-- BOTÓN X --}}
        <a href="{{ route('bienvenido') }}"
           style="
                width:42px;
                height:42px;
                display:flex;
                align-items:center;
                justify-content:center;
                background:white;
                color:#c53030;
                border-radius:50%;
                text-decoration:none;
                font-size:22px;
                font-weight:bold;
                transition:0.3s;
                box-shadow:0 4px 10px rgba(0,0,0,0.15);
           "
           onmouseover="this.style.transform='scale(1.08)'"
           onmouseout="this.style.transform='scale(1)'">
            ✕
        </a>
    </div>

    {{-- CONTENIDO --}}
    <div style="
        background:white;
        border-radius:0 0 18px 18px;
        padding:25px;
        box-shadow:0 8px 20px rgba(0,0,0,0.08);
    ">

        {{-- BOTÓN AGREGAR --}}
        <div class="mb-4">
            <a href="{{ route('proveedores.create') }}"
               style="
                    background: linear-gradient(135deg, #38a169, #48bb78);
                    color:white;
                    padding:12px 22px;
                    border-radius:12px;
                    text-decoration:none;
                    font-weight:600;
                    font-size:15px;
                    display:inline-flex;
                    align-items:center;
                    gap:8px;
                    box-shadow:0 5px 12px rgba(72,187,120,0.3);
                    transition:0.3s;
               "
               onmouseover="this.style.transform='translateY(-2px)'"
               onmouseout="this.style.transform='translateY(0)'">
                ➕ Agregar Proveedor
            </a>
        </div>

        {{-- ALERTA --}}
        @if(session('success'))
            <div style="
                background-color:#d4edda;
                color:#155724;
                padding:12px;
                border-radius:10px;
                margin-bottom:20px;
                border:1px solid #c3e6cb;
            ">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA --}}
        <div style="
            border-radius:15px;
            overflow:hidden;
            border:2px solid #e2e8f0;
        ">

            <table class="table mb-0" style="
                margin:0;
                width:100%;
                border-collapse:collapse;
            ">

                <thead style="
                    background:#c53030;
                    color:white;
                ">
                    <tr>
                        <th style="padding:14px; border:1px solid #ffffff40;">ID</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">Nombre</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">Apellido Paterno</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">Apellido Materno</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">Email</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">Teléfono</th>
                        <th style="padding:14px; border:1px solid #ffffff40;">RFC</th>
                        <th style="padding:14px; border:1px solid #ffffff40; text-align:center;">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($proveedores as $proveedor)

                    <tr style="background:white;">

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->Id_proveedores }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->nombre }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->apellido_pat }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->apellido_mat }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->email }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->telefono }}
                        </td>

                        <td style="padding:14px; border:1px solid #e2e8f0;">
                            {{ $proveedor->RFC }}
                        </td>

                        <td style="
                            padding:14px;
                            border:1px solid #e2e8f0;
                            text-align:center;
                        ">

                            {{-- EDITAR --}}
                            <a href="{{ route('proveedores.edit', $proveedor->Id_proveedores) }}"
                               style="
                                    padding:8px 14px;
                                    background:#3182ce;
                                    color:white;
                                    border-radius:8px;
                                    text-decoration:none;
                                    font-size:14px;
                                    font-weight:600;
                                    margin-right:5px;
                                    display:inline-block;
                               ">
                                Editar
                            </a>

                            {{-- ELIMINAR --}}
                            <form action="{{ route('proveedores.destroy', $proveedor->Id_proveedores) }}"
                                  method="POST"
                                  style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('¿Deseas eliminar este proveedor?')"
                                        style="
                                            padding:8px 14px;
                                            background:#e53e3e;
                                            color:white;
                                            border-radius:8px;
                                            border:none;
                                            cursor:pointer;
                                            font-size:14px;
                                            font-weight:600;
                                        ">
                                    Eliminar
                                </button>
                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8"
                            style="
                                text-align:center;
                                padding:30px;
                                color:#718096;
                                font-weight:500;
                                border:1px solid #e2e8f0;
                            ">
                            No hay proveedores registrados
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection