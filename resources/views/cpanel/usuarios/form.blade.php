@extends('cpanel.app')

@section('title','Registrar Usuario')

@section('content')

<style>

.form-wrapper{
    max-width: 1000px;
    margin: auto;
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
.header-create{
    background: linear-gradient(135deg, #8b0000, #c40000);
    border-radius: 20px;
    padding: 30px;
    color: white;
    margin-bottom: 25px;
    position: relative;
}

.header-create::before{
    content: "👤";
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 80px;
    opacity: 0.15;
}

.form-card{
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.section-title{
    font-weight: bold;
    color: #b30000;
    margin: 20px 0 10px;
    border-left: 4px solid #b30000;
    padding-left: 10px;
}

.row-grid{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.row-grid-2{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

@media(max-width:900px){
    .row-grid,
    .row-grid-2{
        grid-template-columns: 1fr;
    }
}

input, select{
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
}

input:focus, select:focus{
    border-color: #b30000;
    box-shadow: 0 0 5px rgba(179,0,0,0.3);
}

.btn-save{
    background: #b30000;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 25px;
}

.btn-save:disabled{
    background: #999;
}

.alert-box{
    display:none;
    background:#ffe5e5;
    color:#b30000;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}

</style>

<div class="header-create">

 <a href="{{ route('login') }}"
           class="close-button"
           title="Cerrar">

            ✕

        </a>
    <h1>Registrar Usuario</h1>
    <p>Complete todos los campos</p>
</div>

<div class="container form-wrapper">

<div class="form-card">

<div id="alerta" class="alert-box">
    ⚠️ Revisa los campos: faltan datos o hay errores
</div>

<form id="formUsuario" action="{{ route('usuarios.store') }}" method="POST">
@csrf

{{-- PERSONALES --}}
<div class="section-title">Datos Personales</div>

<div class="row-grid">
    <input type="text" name="Nombre" placeholder="Nombre" class="solo-letras">
    <input type="text" name="Ape_pat" placeholder="Apellido Paterno" class="solo-letras">
    <input type="text" name="Ape_mat" placeholder="Apellido Materno" class="solo-letras">
</div>

{{-- CUENTA --}}
<div class="section-title">Cuenta</div>

<div class="row-grid">
    <input type="text" name="Nom_usuario" placeholder="Usuario">
    <input type="email" name="Email" id="email" placeholder="Email">
    <input type="text" name="Telefono" id="telefono" placeholder="Teléfono (10 dígitos)">
</div>

{{-- SEGURIDAD --}}
<div class="row-grid-2">
    <input type="password" name="Contrasena" placeholder="Contraseña">
    <input type="date" name="Fecha_registro" value="{{ date('Y-m-d') }}">
</div>

{{-- DIRECCIÓN --}}
<div class="section-title">Dirección</div>

<div class="row-grid">
    <input type="text" name="Calle" placeholder="Calle">
    <input type="text" name="Numero" placeholder="Número">

    <select id="CP" name="CP">
        <option value="">Selecciona CP</option>
        <option value="72000" data-municipio="Puebla" data-estado="Puebla">72000 - Puebla Centro</option>
        <option value="72160" data-municipio="San Andrés Cholula" data-estado="Puebla">72160 - Cholula</option>
        <option value="74160" data-municipio="San Martín Texmelucan" data-estado="Puebla">74160 - Texmelucan</option>
    </select>
</div>

<div class="row-grid-2">
    <input type="text" id="Municipio" name="Municipio" readonly placeholder="Municipio"> 
    <input type="text" id="Estado" name="Estado" readonly placeholder="Estado">
</div>

<br>

<div style="text-align:center;">
    <button type="submit" id="btnGuardar" class="btn-save">Guardar Usuario</button>
</div>

</form>

</div>
</div>

<script>

// SOLO LETRAS
document.querySelectorAll(".solo-letras").forEach(input=>{
    input.addEventListener("input", e=>{
        e.target.value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚ\s]/g,'');
    });
});

// TELEFONO SOLO NUMEROS + 10 DIGITOS
document.getElementById("telefono").addEventListener("input", function(){
    this.value = this.value.replace(/\D/g,'').slice(0,10);
});

// EMAIL VALIDACION VISUAL
document.getElementById("email").addEventListener("input", function(){
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
    this.style.border = ok ? "2px solid green" : "2px solid red";
});

// CP AUTOFILL
document.getElementById("CP").addEventListener("change", function(){
    let opt = this.options[this.selectedIndex];
    document.getElementById("Municipio").value = opt.dataset.municipio || "";
    document.getElementById("Estado").value = opt.dataset.estado || "";
});

// VALIDACION GENERAL
document.getElementById("formUsuario").addEventListener("submit", function(e){

    let inputs = this.querySelectorAll("input, select");
    let error = false;

    inputs.forEach(i=>{
        if(i.value.trim() === ""){
            error = true;
            i.style.border = "2px solid red";
        }
    });

    // email invalido
    const email = document.getElementById("email");
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);

    if(!emailOk){
        error = true;
        email.style.border = "2px solid red";
    }

    // telefono invalido
    const tel = document.getElementById("telefono");
    if(tel.value.length !== 10){
        error = true;
        tel.style.border = "2px solid red";
    }

    if(error){
        e.preventDefault();
        document.getElementById("alerta").style.display = "block";
    }

});

</script>

@endsection