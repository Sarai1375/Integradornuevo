@extends('cpanel.app')

@section('title','Crear Usuario')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .create-container{
        width: 100%;
        padding: 40px;
    }

    .create-card{
        background: white;
        border-radius: 30px;
        padding: 45px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        position: relative;
    }

    /* BOTÓN X */

    .close-button{

        position: absolute;
        top: 25px;
        right: 25px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #f3f4f6;
        color: #8b0000;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
        transition: 0.3s;
        border: 2px solid transparent;

    }

    .close-button:hover{

        background: #8b0000;
        color: white;
        transform: rotate(90deg);

    }

    /* HEADER */

    .header-create{
        background: linear-gradient(135deg, #8b0000, #c40000);
        border-radius: 25px;
        padding: 35px;
        color: white;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .header-create::before{
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
    }

    .header-text{
        opacity: 0.9;
        margin-top: 10px;
    }

    /* GRID */

    .form-grid{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .form-group{
        display: flex;
        flex-direction: column;
    }

    .full-width{
        grid-column: span 3;
    }

    .two-columns{
        grid-column: span 2;
    }

    /* LABELS */

    .form-label{
        font-weight: 600;
        margin-bottom: 8px;
        color: #444;
    }

    /* INPUTS */

    .form-control,
    .form-select{

        border-radius: 15px;
        padding: 14px;
        border: 1px solid #ddd;
        transition: 0.3s;
        box-shadow: none !important;
        width: 100%;

    }

    .form-control:focus,
    .form-select:focus{

        border-color: #8b0000;
        box-shadow: 0 0 0 0.15rem rgba(139,0,0,0.2) !important;

    }

    /* SECTION */

    .section-title{
        font-size: 1.2rem;
        font-weight: bold;
        color: #8b0000;
        margin-bottom: 25px;
        border-left: 5px solid #8b0000;
        padding-left: 12px;
    }

    /* BUTTONS */

    .buttons-container{
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .btn-custom{
        border-radius: 15px;
        padding: 14px 30px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-custom:hover{
        transform: translateY(-2px);
    }

    .btn-save{
        background: linear-gradient(135deg, #8b0000, #c40000);
        color: white;
        border: none;
    }

    .btn-save:hover{
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

    /* VALIDACIONES */

    .validation-message{
        margin-top: 6px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* RESPONSIVE */

    @media(max-width: 992px){

        .form-grid{
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media(max-width: 768px){

        .create-container{
            padding: 20px;
        }

        .create-card{
            padding: 30px 20px;
        }

        .form-grid{
            grid-template-columns: 1fr;
        }

        .full-width,
        .two-columns{
            grid-column: span 1;
        }

        .header-title{
            font-size: 1.8rem;
        }

    }

</style>

<div class="create-container">

    <div class="create-card">

        <!-- BOTÓN X -->

        <a href="{{ route('usuarios.index') }}"
           class="close-button"
           title="Cerrar">

            ✕

        </a>

        <!-- HEADER -->

        <div class="header-create">

            <h1 class="header-title">
                ➕ Crear Usuario
            </h1>

            <p class="header-text">
                Registra nuevos usuarios dentro del sistema.
            </p>

        </div>

        <!-- ERRORES -->

        @if($errors->any())

            <div class="alert alert-danger mb-4">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route('usuarios.storeAdmin') }}"
              method="POST">

            @csrf

            <!-- DATOS PERSONALES -->

            <div class="section-title">
                Datos Personales
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input type="text"
                           id="Nombre"
                           name="Nombre"
                           class="form-control"
                           value="{{ old('Nombre') }}"
                           required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Apellido Paterno
                    </label>

                    <input type="text"
                           id="Ape_pat"
                           name="Ape_pat"
                           class="form-control"
                           value="{{ old('Ape_pat') }}"
                           required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Apellido Materno
                    </label>

                    <input type="text"
                           id="Ape_mat"
                           name="Ape_mat"
                           class="form-control"
                           value="{{ old('Ape_mat') }}"
                           required>

                </div>

            </div>

            <!-- CUENTA -->

            <div class="section-title">
                Información de Cuenta
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Usuario
                    </label>

                    <input type="text"
                           name="Nom_usuario"
                           class="form-control"
                           value="{{ old('Nom_usuario') }}"
                           required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Email
                    </label>

                    <input type="email"
                           id="Email"
                           name="Email"
                           class="form-control"
                           value="{{ old('Email') }}"
                           required>

                    <div id="emailMessage"
                         class="validation-message">
                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Teléfono
                    </label>

                    <input type="text"
                           id="Telefono"
                           name="Telefono"
                           class="form-control"
                           maxlength="10"
                           value="{{ old('Telefono') }}"
                           required>

                </div>

            </div>

            <!-- SEGURIDAD -->

            <div class="section-title">
                Seguridad
            </div>

            <div class="form-grid">

                <div class="form-group two-columns">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input type="password"
                           id="Contrasena"
                           name="Contrasena"
                           class="form-control"
                           required>

                    <small class="text-muted mt-2">

                        Debe contener:
                        mínimo 8 caracteres,
                        mayúscula,
                        minúscula y número.

                    </small>

                    <div id="passwordMessage"
                         class="validation-message">
                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Fecha Registro
                    </label>

                    <input type="date"
                           name="Fecha_registro"
                           class="form-control"
                           value="{{ old('Fecha_registro', date('Y-m-d')) }}"
                           required>

                </div>

            </div>

            <!-- DIRECCIÓN -->

            <div class="section-title">
                Dirección
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Calle
                    </label>

                    <input type="text"
                           name="Calle"
                           class="form-control"
                           value="{{ old('Calle') }}"
                           required>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Número
                    </label>

                    <input type="text"
                           name="Numero"
                           class="form-control"
                           value="{{ old('Numero') }}"
                           required>

                </div>

                <div class="mb-3">
                    <label>Código Postal</label>

                    <select id="cp"
                            name="CP"
                            class="form-control"
                            onchange="buscarCP(this.value)">

                        <option value="">Selecciona CP</option>

                        @foreach(DB::table('codigos_postales')->select('cp')->distinct()->get() as $codigo)

                            <option value="{{ $codigo->cp }}">
                                {{ $codigo->cp }}
                            </option>

                        @endforeach

                    </select>
                </div>

            </div>

            <!-- UBICACIÓN -->

            <div class="section-title">
                Ubicación
            </div>

            <div class="form-grid">

                <div class="mb-3">
    <label>Municipio</label>

    <input type="text"
           id="municipio"
           name="Municipio"
           class="form-control"
           readonly>
</div>
                <div class="form-group">
<div class="mb-3">
    <label>Estado</label>

    <input type="text"
           id="estado"
           name="Estado"
           class="form-control"
           readonly>
</div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Cliente Frecuente
                    </label>

                    <select name="Frecuente"
                            class="form-select"
                            required>

                        <option value="">
                            -- Selecciona --
                        </option>

                        <option value="Si">
                            Sí
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- BOTONES -->

            <div class="buttons-container">

                <button type="submit"
                        class="btn btn-custom btn-save">

                    💾 Guardar Usuario

                </button>

                <a href="{{ route('usuarios.index') }}"
                   class="btn btn-custom btn-cancel">

                    ↩️ Cancelar

                </a>

            </div>

        </form>

    </div>

</div>

<!-- VALIDACIONES -->

<script>

    /*
    |--------------------------------------------------------------------------
    | SOLO LETRAS
    |--------------------------------------------------------------------------
    */

    function soloLetras(inputId){

        const input =
            document.getElementById(inputId);

        input.addEventListener('input', () => {

            input.value =
                input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');

        });

    }

    soloLetras('Nombre');
    soloLetras('Ape_pat');
    soloLetras('Ape_mat');

    /*
    |--------------------------------------------------------------------------
    | EMAIL
    |--------------------------------------------------------------------------
    */

    const emailInput =
        document.getElementById('Email');

    const emailMessage =
        document.getElementById('emailMessage');

    emailInput.addEventListener('input', () => {

        const regex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(regex.test(emailInput.value)){

            emailMessage.textContent =
                'Email válido ✔';

            emailMessage.style.color =
                'green';

        }else{

            emailMessage.textContent =
                'Formato inválido';

            emailMessage.style.color =
                'red';

        }

    });

    /*
    |--------------------------------------------------------------------------
    | TELÉFONO
    |--------------------------------------------------------------------------
    */

    const telefonoInput =
        document.getElementById('Telefono');

    telefonoInput.addEventListener('input', () => {

        telefonoInput.value =
            telefonoInput.value.replace(/[^0-9]/g,'');

    });

    /*
    |--------------------------------------------------------------------------
    | PASSWORD
    |--------------------------------------------------------------------------
    */

    const passwordInput =
        document.getElementById('Contrasena');

    const passwordMessage =
        document.getElementById('passwordMessage');

    passwordInput.addEventListener('input', () => {

        const val =
            passwordInput.value;

        let errors = [];

        if(val.length < 8)
            errors.push('8 caracteres');

        if(!/[A-Z]/.test(val))
            errors.push('mayúscula');

        if(!/[a-z]/.test(val))
            errors.push('minúscula');

        if(!/[0-9]/.test(val))
            errors.push('número');

        if(errors.length > 0){

            passwordMessage.textContent =
                'Falta: ' + errors.join(', ');

            passwordMessage.style.color =
                'red';

        }else{

            passwordMessage.textContent =
                'Contraseña segura ✔';

            passwordMessage.style.color =
                'green';

        }

    });

    /*
    |--------------------------------------------------------------------------
    | CP -> AUTOCOMPLETE
    |--------------------------------------------------------------------------
    */

    function buscarCP(cp)
{
    if(cp == "") return;

    fetch(`/buscar-cp/${cp}`)
        .then(response => response.json())
        .then(data => {

            document.getElementById("municipio").value = data.municipio;
            document.getElementById("estado").value = data.estado;

        });
}

</script>

@endsection