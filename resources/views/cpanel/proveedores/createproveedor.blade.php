@extends('cpanel.app')

@section('title','Agregar Proveedor')

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

        <div>
            <h2 style="
                color:white;
                font-weight:700;
                margin:0;
            ">
                ➕ Agregar Proveedor
            </h2>

            <p style="
                color:#ffe5e5;
                margin:0;
                margin-top:5px;
            ">
                Completa la información del proveedor
            </p>
        </div>

        {{-- BOTÓN X --}}
        <a href="{{ route('proveedores.index') }}"
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
        padding:30px;
        box-shadow:0 8px 20px rgba(0,0,0,0.08);
    ">

        {{-- ERRORES --}}
        @if ($errors->any())
            <div style="
                background:#fed7d7;
                color:#742a2a;
                border:1px solid #feb2b2;
                padding:15px;
                border-radius:12px;
                margin-bottom:25px;
            ">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('proveedores.store') }}" method="POST">

            @csrf

            <div style="
                display:grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap:25px;
            ">

                {{-- NOMBRE --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Nombre</label>

                    <input type="text"
                           name="nombre"
                           value="{{ old('nombre') }}"
                           required
                           maxlength="40"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                           onkeypress="return /[A-Za-zÁÉÍÓÚáéíóúÑñ ]/.test(event.key)"
                           oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '')"
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;">
                </div>

                {{-- APELLIDO PATERNO --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Apellido Paterno</label>

                    <input type="text"
                           name="apellido_pat"
                           value="{{ old('apellido_pat') }}"
                           required
                           maxlength="40"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                           oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '')"
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;">
                </div>

                {{-- APELLIDO MATERNO --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Apellido Materno</label>

                    <input type="text"
                           name="apellido_mat"
                           value="{{ old('apellido_mat') }}"
                           required
                           maxlength="40"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                           oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g, '')"
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Email</label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;">

                    <small id="emailMsg" style="font-weight:bold;"></small>
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">Teléfono</label>

                    <input type="text"
                           name="telefono"
                           maxlength="10"
                           value="{{ old('telefono') }}"
                           required
                           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;">
                </div>

                {{-- RFC --}}
                <div>
                    <label style="font-weight:600;display:block;margin-bottom:8px;">RFC</label>

                    <input type="text"
                           id="rfc"
                           name="RFC"
                           value="{{ old('RFC') }}"
                           maxlength="13"
                           required
                           style="width:100%;padding:12px;border:1px solid #cbd5e0;border-radius:10px;text-transform:uppercase;">

                    <small id="rfcMsg" style="font-weight:bold;"></small>
                </div>

            </div>

            <div style="margin-top:35px;text-align:right;">

                <button type="submit"
                        style="padding:12px 24px;background:green;color:white;border:none;border-radius:10px;">
                    Guardar Proveedor
                </button>

            </div>

        </form>

    </div>
</div>

{{-- ================= SOLO AÑADIDO ================= --}}
<script>

// EMAIL
document.getElementById('email').addEventListener('input', function () {

    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let msg = document.getElementById('emailMsg');

    if (regex.test(this.value)) {
        msg.textContent = "Email válido ✔";
        msg.style.color = "green";
    } else {
        msg.textContent = "Email inválido";
        msg.style.color = "red";
    }
});


// RFC
document.getElementById('rfc').addEventListener('input', function () {

    this.value = this.value.toUpperCase();

    let regex = /^([A-ZÑ&]{3,4})\d{6}[A-Z0-9]{3}$/;
    let msg = document.getElementById('rfcMsg');

    if (regex.test(this.value)) {
        msg.textContent = "RFC válido ✔";
        msg.style.color = "green";
    } else {
        msg.textContent = "RFC inválido";
        msg.style.color = "red";
    }
});

</script>

@endsection