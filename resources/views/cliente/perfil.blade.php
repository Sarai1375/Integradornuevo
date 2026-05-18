@extends('cliente.app')

@section('title', 'Mi Perfil')

@push('styles')
<style>

    body{
        background: #f4f6f9;
    }

    .form-control{
        width: 100%;
        border-radius: 12px;
        border: 1px solid #ddd;
        padding: 12px 45px 12px 12px;
        outline: none;
        transition: .3s;
        background: #fff;
    }

    .form-control:focus{
        border-color: #8b0000;
        box-shadow: 0 0 8px rgba(139,0,0,.2);
    }

    .profile-card{
        background: white;
        padding: 45px;
        border-radius: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        max-width: 950px;
        margin: 40px auto;
    }

    .profile-top{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .profile-img{
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #8b0000;
        margin-bottom: 15px;
        background: #fff;
    }

    .icon-selector{
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .icon-option{
        width: 65px;
        height: 65px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: .3s;
        object-fit: cover;
        background: #f4f4f4;
        padding: 5px;
    }

    .icon-option:hover{
        transform: scale(1.08);
        border-color: #8b0000;
    }

    .badge-client{
        background: #8b0000;
        color: white;
        padding: 8px 18px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 12px;
        font-weight: 500;
    }

    .info-box{
        margin-top: 35px;
    }

    .section-title{
        border-bottom: 1px solid #eee;
        margin-bottom: 25px;
        padding-bottom: 12px;
    }

    .section-title h4{
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .info-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item{
        background: #fafafa;
        padding: 20px;
        border-radius: 18px;
        border: 1px solid #eee;
        transition: .3s;
    }

    .info-item:hover{
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .info-item label{
        display: block;
        font-weight: bold;
        font-size: 0.82rem;
        color: #777;
        margin-bottom: 10px;
    }

    .info-item p{
        margin: 0;
        color: #333;
        font-size: 1rem;
    }

    .input-edit{
        position: relative;
    }

    .input-edit i{
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8b0000;
        font-size: 15px;
        cursor: pointer;
    }

    .readonly-box{
        background: #f1f1f1;
        color: #777;
    }

    .description-box{
        margin-top: 20px;
        padding: 20px;
        background: #fafafa;
        border-radius: 18px;
        border: 1px solid #eee;
    }

    .description-box label{
        display: block;
        font-weight: bold;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 10px;
    }

    .description-box textarea{
        background: #f1f1f1;
        resize: none;
        cursor: not-allowed;
    }

    .upload-btn{
        background: #8b0000;
        color: white;
        border: none;
        padding: 12px 22px;
        border-radius: 12px;
        cursor: pointer;
        transition: .3s;
        margin-top: 10px;
        font-weight: 600;
    }

    .upload-btn:hover{
        background: #a30000;
        transform: scale(1.03);
    }

    input[type="file"]{
        display: none;
    }

    @media(max-width:768px){

        .profile-card{
            padding: 25px;
        }

        .info-grid{
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush

@section('content')

<div class="profile-card">

    <div class="profile-top">

        <!-- FOTO PRINCIPAL -->
        <img src="{{ asset('images/icons/icon1.png') }}" 
             id="mainProfile" 
             class="profile-img">

        <!-- SUBIR FOTO -->
        <label for="uploadPhoto" class="upload-btn">
            📸 Subir Foto
        </label>

        <input type="file" id="uploadPhoto" accept="image/*">

        <h2>
            {{ session('nombre') }}
            {{ session('ape_pat') }}
            {{ session('ape_mat') }}
        </h2>

        @if(session('frecuente') == 'Si')

            <div class="badge-client">
                Cliente Frecuente 🌹
            </div>

        @endif

        <!-- ICONOS -->
        <div class="icon-selector">

            <img src="{{ asset('images/icons/icon1.png') }}"
                 class="icon-option"
                 onclick="changeProfile(this.src)">

            <img src="{{ asset('images/icons/icon2.png') }}"
                 class="icon-option"
                 onclick="changeProfile(this.src)">

            <img src="{{ asset('images/icons/icon3.png') }}"
                 class="icon-option"
                 onclick="changeProfile(this.src)">

            <img src="{{ asset('images/icons/icon4.png') }}"
                 class="icon-option"
                 onclick="changeProfile(this.src)">

            <img src="{{ asset('images/icons/icon5.png') }}"
                 class="icon-option"
                 onclick="changeProfile(this.src)">

        </div>

    </div>

    <form action="{{ route('cliente.perfil.actualizar') }}" method="POST">
        @csrf

        <div class="info-box">

            <div class="section-title">
                <h4>Información del Cliente</h4>
            </div>

            <!-- FILA 1 -->
            <div class="info-grid">
                <div class="info-item">
                <label>📧 CORREO ELECTRÓNICO</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    value="{{ session('email') }}"
                    required>
            </div>
                <div class="info-item">
                    <label>📞 TELÉFONO</label>
                 <!-- TELÉFONO -->
                        <div class="input-edit">
                            <input type="text"
                                name="telefono"
                                class="form-control"
                                maxlength="10"
                                pattern="[0-9]{10}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                value="{{ $usuario->Telefono }}"
                                required>
                        </div>

            </div>

            <!-- FILA DIRECCIÓN -->
            <div class="info-grid">

                <div class="info-item">
                    <label>🏠 CALLE</label>

                    <div class="input-edit">
                        <input type="text"
                               name="calle"
                               class="form-control"
                                pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+"
                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑ\s]/g, '')"
                               value="{{ $usuario->Calle }}">
                    </div>
                </div>

                <div class="info-item">
                    <label>🔢 NÚMERO</label>

                    <div class="input-edit">
                        <input type="text"
                               name="numero"
                               class="form-control"
                               maxlength="10"
                                pattern="[0-9]+"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               value="{{ $usuario->Numero }}">
                    </div>
                </div>

            </div>

            <div class="info-grid">

                <div class="info-item">

                    <label>📮 CÓDIGO POSTAL</label>

                    <div class="input-edit">
                        <select name="cp"
                                id="cp"
                                class="form-control">

                            <option value="">Selecciona un CP</option>

                            <option value="74000"
                                data-estado="Puebla"
                                data-municipio="San Martín Texmelucan"
                                {{ $usuario->CP == '74000' ? 'selected' : '' }}>
                                74000
                            </option>

                            <option value="74160"
                                data-estado="Puebla"
                                data-municipio="Huejotzingo"
                                {{ $usuario->CP == '74160' ? 'selected' : '' }}>
                                74160
                            </option>

                            <option value="72000"
                                data-estado="Puebla"
                                data-municipio="Puebla"
                                {{ $usuario->CP == '72000' ? 'selected' : '' }}>
                                72000
                            </option>

                        </select>

                    </div>

                </div>

                <div class="info-item">
                    <label>🌎 ESTADO</label>

                    <input type="text"
                           name="estado"
                           id="estado"
                           class="form-control readonly-box"
                           value="{{ $usuario->Estado }}"
                           readonly>
                </div>

            </div>

            <div class="info-grid">

                <div class="info-item">
                    <label>🏙️ MUNICIPIO</label>

                    <input type="text"
                           name="municipio"
                           id="municipio"
                           class="form-control readonly-box"
                           value="{{ $usuario->Municipio }}"
                           readonly>
                </div>

                <div class="info-item">
                    <label>🔒 NUEVA CONTRASEÑA</label>

                    <div class="input-edit">
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="********"
                           minlength="8"
                           pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._-])[A-Za-z\d@$!%*#?&._-]{8,}$"
                           title="La contraseña debe tener mínimo 8 caracteres, incluyendo letras, números y caracteres especiales."
                            onclick="this.value='';">
                        <i>✏️</i>
                    </div>
                </div>

            </div>

            <!-- FILA 3 -->
            <div class="info-grid">

                <div class="info-item">
                    <label>📦 ACTIVIDAD</label>

                    @if($usuario->Frecuente == 'Si')

                        <p>Cliente Frecuente 🌹</p>

                    @else

                        <p>Cliente Ocasional</p>

                    @endif

                </div>

            </div>


            <div class="text-center mt-4">

                <button type="submit" class="upload-btn">
                    Guardar Cambios
                </button>
                

            </div>

        </div>

    </form>

</div>
@if(session('success'))

    <div class="alert-success-custom">
        ✅ {{ session('success') }}
    </div>

@endif
<script>

    // CAMBIAR ICONO
    function changeProfile(src){

        document.getElementById('mainProfile').src = src;

    }

    // SUBIR FOTO PERSONAL
    document.getElementById('uploadPhoto').addEventListener('change', function(event){

        const file = event.target.files[0];

        if(file){

            const reader = new FileReader();

            reader.onload = function(e){

                document.getElementById('mainProfile').src = e.target.result;

            }

            reader.readAsDataURL(file);

        }

    });

</script>

<script>

    const cpSelect = document.getElementById('cp');

    cpSelect.addEventListener('change', function(){

        const option =
            this.options[this.selectedIndex];

        const estado =
            option.getAttribute('data-estado');

        const municipio =
            option.getAttribute('data-municipio');

        document.getElementById('estado').value =
            estado;

        document.getElementById('municipio').value =
            municipio;

    });

</script>
@endsection