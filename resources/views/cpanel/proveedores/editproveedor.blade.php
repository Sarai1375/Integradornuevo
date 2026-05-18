@extends('cpanel.app')
@section('title','Editar Proveedor')

@section('content')

<style>
    .form-card {
        max-width: 800px;
        margin: auto;
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .form-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #2d3748;
        text-align: center;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #4a5568;
    }

    .form-group input {
        padding: 10px;
        border: 2px solid #cbd5e0;
        border-radius: 8px;
        outline: none;
        transition: 0.2s;
    }

    .form-group input:focus {
        box-shadow: 0 0 0 2px rgba(49,130,206,0.2);
    }

    .valid {
        border-color: #38a169 !important;
    }

    .invalid {
        border-color: #e53e3e !important;
    }

    .error-msg {
        font-size: 12px;
        color: #e53e3e;
        margin-top: 4px;
        display: none;
    }

    .error-msg.show {
        display: block;
    }

    .form-actions {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-primary {
        padding: 10px 18px;
        background: #3182ce;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-secondary {
        padding: 10px 18px;
        background: #718096;
        color: white;
        border-radius: 8px;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container py-4">

    <div class="form-card">

        <div class="form-title">Editar Proveedor</div>

        <form action="{{ route('proveedores.update', $proveedor->Id_proveedores) }}" method="POST" id="formProveedor">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" id="nombre"
                        value="{{ $proveedor->nombre }}" required>
                    <span class="error-msg" id="error-nombre">Solo se permiten letras</span>
                </div>

                <div class="form-group">
                    <label>Apellido Paterno:</label>
                    <input type="text" name="apellido_pat" id="apellido_pat"
                        value="{{ $proveedor->apellido_pat }}" required>
                    <span class="error-msg" id="error-apellido_pat">Solo se permiten letras</span>
                </div>

                <div class="form-group">
                    <label>Apellido Materno:</label>
                    <input type="text" name="apellido_mat" id="apellido_mat"
                        value="{{ $proveedor->apellido_mat }}" required>
                    <span class="error-msg" id="error-apellido_mat">Solo se permiten letras</span>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" id="email"
                        value="{{ $proveedor->email }}" required>
                    <span class="error-msg" id="error-email">Correo inválido</span>
                </div>

                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="text" name="telefono" id="telefono"
                        value="{{ $proveedor->telefono }}" maxlength="10" required>
                    <span class="error-msg" id="error-telefono">Debe tener 10 dígitos</span>
                </div>

                <div class="form-group">
                    <label>RFC:</label>
                    <input type="text" name="RFC" id="rfc"
                        value="{{ $proveedor->RFC }}" maxlength="13" required>
                    <span class="error-msg" id="error-rfc">RFC inválido</span>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('proveedores.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Actualizar</button>
            </div>

        </form>
    </div>

</div>

<script>
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const rfcRegex = /^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/;

    function setEstado(input, errorId, valido, mensaje) {
        const error = document.getElementById(errorId);

        if (valido) {
            input.classList.add('valid');
            input.classList.remove('invalid');
            error.classList.remove('show');
        } else {
            input.classList.add('invalid');
            input.classList.remove('valid');
            error.classList.add('show');
        }
    }

    // 🚫 Bloquear números en tiempo real
    function soloTexto(input) {
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    }

    const nombre = document.getElementById('nombre');
    const apPat = document.getElementById('apellido_pat');
    const apMat = document.getElementById('apellido_mat');
    const email = document.getElementById('email');
    const telefono = document.getElementById('telefono');
    const rfc = document.getElementById('rfc');

    nombre.addEventListener('input', () => {
        soloTexto(nombre);
        setEstado(nombre, 'error-nombre', soloLetras.test(nombre.value.trim()));
    });

    apPat.addEventListener('input', () => {
        soloTexto(apPat);
        setEstado(apPat, 'error-apellido_pat', soloLetras.test(apPat.value.trim()));
    });

    apMat.addEventListener('input', () => {
        soloTexto(apMat);
        setEstado(apMat, 'error-apellido_mat', soloLetras.test(apMat.value.trim()));
    });

    email.addEventListener('input', () => {
        setEstado(email, 'error-email', emailRegex.test(email.value.trim()));
    });

    telefono.addEventListener('input', () => {
        telefono.value = telefono.value.replace(/\D/g, '');
        setEstado(telefono, 'error-telefono', telefono.value.length === 10);
    });

    rfc.addEventListener('input', () => {
        rfc.value = rfc.value.toUpperCase();
        setEstado(rfc, 'error-rfc', rfcRegex.test(rfc.value.trim()));
    });

    document.getElementById('formProveedor').addEventListener('submit', function(e) {
        let ok =
            soloLetras.test(nombre.value.trim()) &
            soloLetras.test(apPat.value.trim()) &
            soloLetras.test(apMat.value.trim()) &
            emailRegex.test(email.value.trim()) &
            (telefono.value.length === 10) &
            rfcRegex.test(rfc.value.trim());

        if (!ok) {
            e.preventDefault();
            alert("Corrige los campos marcados en rojo");
        }
    });
</script>

@endsection