@extends('cpanel.app')

@section('title', 'Inicio')

@push('styles')
<style>

    body{
        background: #f5f5f5;
    }

    /* HERO */
    .hero {
        background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                    url('/images/inverna.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 15px;
        padding: 80px 40px;
        color: white;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .hero h1{
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .hero p{
        font-size: 1.2rem;
        max-width: 700px;
        margin: auto;
    }

    .hero-buttons{
        margin-top: 25px;
    }

    .hero-buttons a{
        text-decoration: none;
        background: #b1122d;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        margin: 5px;
        display: inline-block;
        transition: 0.3s;
    }

    .hero-buttons a:hover{
        background: #8f0d24;
    }

    /* BUSCADOR */
    .search-box {
        margin: 20px auto;
        max-width: 500px;
        display: flex;
        gap: 10px;
    }

    .search-box input {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .search-box button {
        background-color: #b1122d;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
    }

    /* SECCIONES */
    .section-title{
        text-align: center;
        margin-top: 50px;
        margin-bottom: 30px;
        color: #b1122d;
        font-weight: bold;
    }

    /* BENEFICIOS */
    .beneficios{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .beneficio-card{
        background: white;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .beneficio-card:hover{
        transform: translateY(-5px);
    }

    .beneficio-card h4{
        margin-top: 10px;
        color: #b1122d;
    }

    /* PRODUCTOS */
    .productos {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        text-align: center;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card h3 {
        padding-top: 10px;
        font-size: 1.1rem;
    }

    .card p{
        padding: 0 15px 15px;
        color: #666;
    }

    /* SOBRE NOSOTROS */
    .about{
        background: white;
        padding: 40px;
        border-radius: 15px;
        margin-top: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        text-align: center;
    }

    .about p{
        max-width: 850px;
        margin: auto;
        line-height: 1.8;
        color: #555;
    }

    /* TEMPORADAS */
    .temporadas{
        margin-top: 50px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .temporada-card{
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .temporada-card h4{
        color: #b1122d;
    }

</style>
@endpush

@section('content')

<!-- HERO -->
<div class="hero">
    <h1>Rosas frescas directo del invernadero 🌹</h1>

    <p>
        En Invernaderos Javier Domínguez ofrecemos rosas de alta calidad
        para floristas, decoradores y negocios, garantizando frescura,
        belleza y entrega confiable.
    </p>

    <div class="hero-buttons">
        <a href="#">Número de contacto 2481299529 </a>
    </div>
</div>



<!-- BENEFICIOS -->
<h2 class="section-title">¿Por qué elegirnos?</h2>

<div class="beneficios">

    <div class="beneficio-card">
        <h1>🌹</h1>
        <h4>Calidad Premium</h4>
        <p>Rosas cultivadas con altos estándares de frescura y duración.</p>
    </div>

    <div class="beneficio-card">
        <h1>🚚</h1>
        <h4>Entregas rápidas</h4>
        <p>Distribución eficiente para pedidos locales y mayoreo.</p>
    </div>

    <div class="beneficio-card">
        <h1>💐</h1>
        <h4>Gran variedad</h4>
        <p>Diferentes colores y estilos para toda ocasión.</p>
    </div>

    <div class="beneficio-card">
        <h1>💰</h1>
        <h4>Precios accesibles</h4>
        <p>Precios especiales para negocios y compras grandes.</p>
    </div>

</div>

<!-- PRODUCTOS -->
<h2 class="section-title">Nuestras rosas</h2>

<div class="productos">

    <div class="card">
        <img src="/images/inverna.jpg" alt="rosa roja">
        <h3>Rosa Roja 🌹</h3>
        <p>Ideal para fechas románticas y arreglos elegantes.</p>
    </div>

    <div class="card">
        <img src="/images/blanca.jpg" alt="Rosa blanca">
        <h3>Rosa Blanca 🤍</h3>
        <p>Perfecta para bodas, eventos y decoraciones delicadas.</p>
    </div>

    <div class="card">
        <img src="/images/rosa.jpg" alt="Rosa rosa">
        <h3>Rosa Rosa 🌸</h3>
        <p>Muy utilizada para regalos y decoraciones modernas.</p>
    </div>

    <div class="card">
        <img src="/images/amarilla.jpg" alt="Rosa amarilla">
        <h3>Rosa Amarilla 🌟</h3>
        <p>Excelente para celebraciones y eventos alegres.</p>
    </div>

</div>

<!-- SOBRE NOSOTROS -->
<div class="about">

    <h2 class="section-title">Sobre nuestros invernaderos</h2>

    <p>
        En Invernaderos Javier Domínguez trabajamos con dedicación
        para producir rosas frescas y de excelente calidad.
        Nuestros cultivos son cuidadosamente supervisados para garantizar
        flores con colores intensos, mayor duración y presentación ideal
        para florerías, decoradores y negocios de eventos.
    </p>

</div>

<!-- TEMPORADAS -->
<h2 class="section-title">Rosas más solicitadas por temporada</h2>

<div class="temporadas">

    <div class="temporada-card">
        <h4>❤️ Febrero</h4>
        <p>Alta demanda de rosas rojas para San Valentín.</p>
    </div>

    <div class="temporada-card">
        <h4>🌼 Marzo</h4>
        <p>Las rosas amarillas destacan por eventos primaverales.</p>
    </div>

    <div class="temporada-card">
        <h4>🌸 Mayo</h4>
        <p>Rosas rosas populares para celebraciones y regalos.</p>
    </div>

    <div class="temporada-card">
        <h4>🎄 Diciembre</h4>
        <p>Las rosas blancas y rojas son tendencia navideña.</p>
    </div>

</div>

@endsection