@extends('cpanel.app')

@section('title','Usuarios')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .users-container{
        padding: 30px;
    }

    .table tbody td{

        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* BOTON REGRESAR */
    .back-container{
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .btn-back-admin{
        background: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        text-decoration: none;
        font-size: 22px;
        color: #8b0000;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: 0.3s;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back-admin:hover{
        background: #8b0000;
        color: white;
    }

    /* ALERTA ADMIN */
    .admin-alert{

        background: #ffe5e5;
        border-left: 8px solid #ff0000;
        color: #b30000;

        padding: 18px 25px;
        margin-bottom: 25px;

        border-radius: 18px;

        display: flex;
        align-items: center;
        gap: 18px;

        box-shadow: 0 5px 15px rgba(255,0,0,0.15);

        animation: aparecer 0.4s ease;
    }

    .icon-alert{
        font-size: 42px;
    }

    .admin-alert strong{
        font-size: 18px;
    }

    @keyframes aparecer{

        from{
            opacity: 0;
            transform: translateY(-10px);
        }

        to{
            opacity: 1;
            transform: translateY(0);
        }

    }

    /* HEADER */
    .header-box{
        background: linear-gradient(135deg, #8b0000, #c40000);
        border-radius: 28px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .header-title{
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .header-text{
        opacity: 0.95;
        font-size: 15px;
    }

    /* BOTONES */
    .actions-box{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 25px;
    }

    .btn-custom{
        padding: 11px 18px;
        border-radius: 14px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        border: none;
        transition: 0.3s;
        font-size: 14px;
    }

    .btn-custom:hover{
        transform: translateY(-2px);
        color: white;
    }

    .btn-green{
        background: #28a745;
    }

    .btn-blue{
        background: #007bff;
    }

    .btn-dark{
        background: #495057;
    }

    .btn-red{
        background: #dc3545;
    }

    .btn-purple{
        background: #6f42c1;
    }

    /* ALERT SUCCESS */
    .alert-success-custom{
        background: #d4edda;
        color: #155724;
        padding: 15px 18px;
        border-radius: 15px;
        margin-bottom: 20px;
        font-weight: 500;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* TABLA */
    .table-container{
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .table{
        margin: 0;
    }

    .table thead{
        background: #8b0000;
        color: white;
    }

    .table thead th{
        padding: 18px 15px;
        font-size: 14px;
        border: none;
        white-space: nowrap;
        text-align: center;
    }

    .table tbody td{
        padding: 16px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
        white-space: nowrap;
        text-align: center;
        font-size: 14px;
    }

    .table tbody tr:hover{
        background: #fafafa;
        transition: 0.2s;
    }

    /* NOMBRE */
    .user-name{
        text-align: left;
        line-height: 1.3;
    }

    .user-name strong{
        color: #222;
        font-size: 15px;
    }

    .user-name small{
        color: #777;
        font-size: 12px;
    }

    /* BADGES */
    .badge-frecuente{
        background: #28a745;
        color: white;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-no{
        background: #6c757d;
        color: white;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ACCIONES */
    .actions-buttons{
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .btn-action{
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: white;
        text-decoration: none;
        transition: 0.3s;
        font-size: 16px;
    }

    .btn-action:hover{
        transform: scale(1.05);
        color: white;
    }

    .btn-edit{
        background: #007bff;
    }

    .btn-delete{
        background: #dc3545;
    }

    /* RESPONSIVE */
    .table-responsive{
        overflow-x: auto;
    }

</style>

<div class="users-container">

    <div class="back-container">

    <a href="{{ url('/bienvenido') }}"
       class="btn-back-admin">

        ✕

    </a>

</div>

    <!-- HEADER -->
    <div class="header-box">

        <h1 class="header-title">
            👥 Gestión de Usuarios
        </h1>

        <p class="header-text">
            Administra usuarios, empleados y clientes registrados en el sistema.
        </p>

    </div>

    <form action="{{ route('usuarios.eliminar-seleccion') }}" method="POST">

        @csrf

        <!-- BOTONES -->
        <div class="actions-box">

            <a href="{{ route('usuarios.create') }}"
               class="btn-custom btn-green">
                ➕ Crear Usuario
            </a>

            <a href="{{ URL('admon/reportes/pdf') }}"
               target="_blank"
               class="btn-custom btn-blue">
                📄 PDF
            </a>

            <a href="{{ route('reporte.excel') }}"
               class="btn-custom btn-dark">
                📊 Excel
            </a>

            <button type="submit"
                    onclick="return confirm('¿Deseas eliminar los usuarios seleccionados?')"
                    class="btn-custom btn-red">

                🗑️ Eliminar Selección

            </button>

            <a href="{{ route('usuarios.graficar') }}"
               class="btn-custom btn-purple">
                📈 Gráficas
            </a>

        </div>

        <!-- ALERTAS -->
        @if(session('success'))

            <div class="alert-success-custom">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

        <div class="admin-alert">

            <span class="icon-alert">🚫</span>

            <div>
                <strong>ACCESO DENEGADO</strong><br>
                No puedes eliminar un administrador protegido.
            </div>

        </div>

        @endif

        <!-- TABLA -->
        <div class="table-container">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Sel</th>

                            <th>ID</th>

                            <th>Nombre Completo</th>

                            <th>Usuario</th>

                            <th>Email</th>

                            <th>Teléfono</th>

                            <th>Municipio</th>

                            <th>Frecuencia</th>

                            <th>Registro</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $fila)

                        <tr>

                            <td>
                                <input type="checkbox"
                                       name="seleccion[]"
                                       value="{{ $fila->Id_Usuario }}">
                            </td>

                            <td>
                                {{ $fila->Id_Usuario }}
                            </td>

                            <td class="user-name">

                                <strong>
                                    {{ $fila->Nombre }}
                                </strong>

                                <br>

                                <small>
                                    {{ $fila->Ape_pat }}
                                    {{ $fila->Ape_mat }}
                                </small>

                            </td>

                            <td>
                                {{ $fila->Nom_usuario }}
                            </td>

                            <td>
                                {{ $fila->Email }}
                            </td>

                            <td>
                                {{ $fila->Telefono }}
                            </td>

                            <td>
                                {{ $fila->Municipio }}
                            </td>

                            <td>

                                @if($fila->Frecuente == 'Si')

                                    <span class="badge-frecuente">
                                        Sí
                                    </span>

                                @else

                                    <span class="badge-no">
                                        No
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $fila->Fecha_registro }}
                            </td>

                            <td>

                                <div class="actions-buttons">

                                    <!-- EDITAR -->
                                    <a href="{{ route('usuarios.edit', $fila->Id_Usuario) }}"
                                       class="btn-action btn-edit">

                                        ✏️

                                    </a>

                                    <!-- ELIMINAR -->
                                    <form action="{{ route('usuarios.eliminar', $fila->Id_Usuario) }}"
                                          method="POST">

                                        @csrf

                                        <button type="submit"
                                                onclick="return confirm('¿Deseas eliminar este usuario?')"
                                                class="btn-action btn-delete">

                                            🗑️

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9" class="text-center py-4">

                                No hay usuarios registrados

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </form>

</div>

@endsection