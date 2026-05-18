@extends('cpanel.app')

@section('title','Editar Usuario')

@section('content')

<style>
    body{
        background: #f4f6f9;
    }

    .edit-container{
        max-width: 1250px;
        margin: auto;
        padding: 35px;
    }

    .edit-card{
        background: white;
        border-radius: 10px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: none;
    }

    /* HEADER */
    .header-edit{
        background: linear-gradient(135deg, #8b0000, #c40000);
        border-radius: 25px;
        padding: 35px;
        margin-bottom: 40px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .header-edit::before{
        content: "👤";
        position: absolute;
        right: 30px;
        top: 10px;
        font-size: 90px;
        opacity: 0.15;
    }

    .header-title{
        font-size: 2.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .header-text{
        opacity: 0.9;
        font-size: 1rem;
    }

    /* LABELS */
    .form-label{
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
    }

    /* INPUTS */
    .form-control,
    .form-select{
        border-radius: 15px;
        border: 1px solid #ddd;
        padding: 14px;
        font-size: 15px;
        transition: 0.3s;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus{
        border-color: #8b0000;
        box-shadow: 0 0 0 0.15rem rgba(139,0,0,0.2) !important;
    }

    /* SECCIONES */
    .section-title{
        font-size: 1.1rem;
        font-weight: bold;
        color: #8b0000;
        margin-bottom: 20px;
        margin-top: 10px;
        border-left: 5px solid #8b0000;
        padding-left: 10px;
    }

    /* ALERT */
    .alert{
        border-radius: 15px;
    }

    /* BOTONES */
    .btn-custom{
        border-radius: 15px;
        padding: 14px 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-custom:hover{
        transform: translateY(-2px);
    }

    .btn-update{
        background: linear-gradient(135deg, #8b0000, #c40000);
        color: white;
        border: none;
    }

    .btn-update:hover{
        background: linear-gradient(135deg, #a80000, #ff0000);
        color: white;
    }

    .btn-cancel{
        border: 2px solid #6c757d;
        color: #6c757d;
        background: white;
    }

    .btn-cancel:hover{
        background: #6c757d;
        color: white;
    }

    /* PASSWORD */
    #passwordMessage{
        font-size: 0.9rem;
        font-weight: 500;
    }

</style>

<div class="edit-container">

    <div class="edit-card">

        <!-- HEADER -->
        <div class="header-edit">

            <h1 class="header-title">
                 Editar Usuario
            </h1>

            <p class="header-text">
                Actualiza la información del usuario registrado en el sistema.
            </p>

        </div>

        <!-- ERRORES -->
        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form action="{{ url('/admon/usuarios/'.$fila->Id_Usuario) }}"
              method="POST">

            @csrf
            @method('PATCH')

            <!-- DATOS PERSONALES -->
            <div class="section-title">
                Datos Personales
            </div>

            <div class="row g-4 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Nombre</label>

                    <input type="text"
                           name="Nombre"
                           class="form-control solo-letras"
                           value="{{ old('Nombre', $fila->Nombre) }}"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                           title="Solo se permiten letras"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Apellido Paterno</label>

                    <input type="text"
                           name="Ape_pat"
                           class="form-control solo-letras"
                           value="{{ old('Ape_pat', $fila->Ape_pat) }}"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                           title="Solo se permiten letras"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Apellido Materno</label>

                    <input type="text"
                           name="Ape_mat"
                           class="form-control solo-letras"
                           value="{{ old('Ape_mat', $fila->Ape_mat) }}"
                           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                           title="Solo se permiten letras"
                           required>
                </div>

            </div>

            <!-- CUENTA -->
            <div class="section-title">
                Información de Cuenta
            </div>

            <div class="row g-4 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Usuario</label>

                    <input type="text"
                           name="Nom_usuario"
                           class="form-control"
                           value="{{ old('Nom_usuario', $fila->Nom_usuario) }}"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Correo Electrónico</label>

                    <input type="email"
                           name="Email"
                           class="form-control"
                           value="{{ old('Email', $fila->Email) }}"
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                           title="Ingresa un correo válido"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>

                    <input type="text"
                           name="Telefono"
                           class="form-control solo-numeros"
                           maxlength="10"
                           value="{{ old('Telefono', $fila->Telefono) }}"
                           pattern="[0-9]+"
                           title="Solo se permiten números"
                           required>
                </div>

            </div>

            <!-- SEGURIDAD -->
            <div class="section-title">
                Seguridad
            </div>

            <div class="row g-4 mb-4">

                <div class="col-md-6">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input type="password"
                           id="Contrasena"
                           name="Contrasena"
                           class="form-control"
                           value="{{ old('Contrasena', $fila->Contrasena) }}"
                           required>

                    <small class="text-muted">

                        Debe contener mayúsculas,
                        minúsculas y números.

                    </small>

                    <div id="passwordMessage" class="mt-2"></div>

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Fecha de Registro
                    </label>

                    <input type="date"
                           name="Fecha_registro"
                           class="form-control"
                           value="{{ old('Fecha_registro', $fila->Fecha_registro) }}"
                           required>

                </div>

            </div>

            <!-- DIRECCIÓN -->
            <div class="section-title">
                Dirección
            </div>

            <div class="row g-4 mb-4">

                <div class="col-md-4">

                    <label class="form-label">
                        Calle
                    </label>

                    <input type="text"
                           name="Calle"
                           class="form-control"
                           value="{{ old('Calle', $fila->Calle) }}"
                           required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Número
                    </label>

                    <input type="text"
                           name="Numero"
                           class="form-control"
                           value="{{ old('Numero', $fila->Numero) }}"
                           required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Código Postal
                    </label>

                    <select name="CP"
                            id="CP"
                            class="form-select"
                            required>

                        <option value="">
                            -- Selecciona un código postal --
                        </option>

                        <option value="72000"
                            {{ old('CP', $fila->CP) == '72000' ? 'selected' : '' }}>
                            72000
                        </option>

                        <option value="72100"
                            {{ old('CP', $fila->CP) == '72100' ? 'selected' : '' }}>
                            72100
                        </option>

                        <option value="74000"
                            {{ old('CP', $fila->CP) == '74000' ? 'selected' : '' }}>
                            74000
                        </option>

                        <option value="74100"
                            {{ old('CP', $fila->CP) == '74100' ? 'selected' : '' }}>
                            74100
                        </option>

                    </select>

                </div>

            </div>

            <!-- UBICACIÓN -->
            <div class="section-title">
                Ubicación
            </div>

            <div class="row g-4 mb-5">

                <div class="col-md-4">

                    <label class="form-label">
                        Municipio
                    </label>

                    <input type="text"
                           id="Municipio"
                           name="Municipio"
                           class="form-control"
                           value="{{ old('Municipio', $fila->Municipio) }}"
                           readonly
                           required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Estado
                    </label>

                    <input type="text"
                           id="Estado"
                           name="Estado"
                           class="form-control"
                           value="{{ old('Estado', $fila->Estado) }}"
                           readonly
                           required>

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Cliente Frecuente
                    </label>

                    <select name="Frecuente"
                            class="form-select"
                            required>

                        <option value="">
                            -- Selecciona --
                        </option>

                        <option value="Si"
                            {{ old('Frecuente', $fila->Frecuente) == 'Si' ? 'selected' : '' }}>
                            Sí
                        </option>

                        <option value="No"
                            {{ old('Frecuente', $fila->Frecuente) == 'No' ? 'selected' : '' }}>
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- BOTONES -->
            <div class="d-flex justify-content-center gap-4">

                <button type="submit"
                        class="btn btn-custom btn-update">

                    💾 Actualizar Usuario

                </button>

                <a href="{{ route('usuarios.index') }}"
                   class="btn btn-custom btn-cancel">

                    ↩️ Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

<!-- VALIDACIÓN PASSWORD -->
<script>

    const passwordInput = document.getElementById('Contrasena');
    const passwordMessage = document.getElementById('passwordMessage');

    passwordInput.addEventListener('input', () => {

        const val = passwordInput.value;

        let msg = '';

        if(val.length < 6)
            msg += 'Mínimo 6 caracteres. ';

        if(!/[A-Z]/.test(val))
            msg += 'Debe contener una mayúscula. ';

        if(!/[a-z]/.test(val))
            msg += 'Debe contener una minúscula. ';

        if(!/[0-9]/.test(val))
            msg += 'Debe contener un número. ';

        passwordMessage.textContent = msg;

        passwordMessage.style.color = msg ? 'red' : 'green';

        if(!msg){
            passwordMessage.textContent = 'Contraseña válida ✔';
        }

    });

    // SOLO LETRAS
    document.querySelectorAll('.solo-letras').forEach(input => {

        input.addEventListener('input', function(){

            this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');

        });

    });

    // SOLO NÚMEROS
    document.querySelectorAll('.solo-numeros').forEach(input => {

        input.addEventListener('input', function(){

            this.value = this.value.replace(/[^0-9]/g, '');

        });

    });

    // AUTOCOMPLETAR MUNICIPIO Y ESTADO
    const cpSelect = document.getElementById('CP');
    const municipioInput = document.getElementById('Municipio');
    const estadoInput = document.getElementById('Estado');

    const datosCP = {

        '72000': {
            municipio: 'Puebla',
            estado: 'Puebla'
        },

        '72100': {
            municipio: 'Puebla',
            estado: 'Puebla'
        },

        '74000': {
            municipio: 'San Martín Texmelucan',
            estado: 'Puebla'
        },

        '74100': {
            municipio: 'Huejotzingo',
            estado: 'Puebla'
        }

    };

    cpSelect.addEventListener('change', function(){

        const cp = this.value;

        if(datosCP[cp]){

            municipioInput.value = datosCP[cp].municipio;
            estadoInput.value = datosCP[cp].estado;

        }else{

            municipioInput.value = '';
            estadoInput.value = '';

        }

    });

</script>

@endsection