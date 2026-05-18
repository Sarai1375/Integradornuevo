@extends('cpanel.app')

@section('title', 'Gráfica por Municipio')

@section('content')

<style>

    body{
        background: #f4f6f9;
    }

    .grafica-container{
        padding: 30px;
    }

    .grafica-card{
        background: #fff;
        border-radius: 25px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        max-width: 950px;
        margin: auto;
        position: relative;
    }

    .btn-regresar{
        position: absolute;
        top: 20px;
        right: 20px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: #d96c8f;
        color: white;
        font-size: 22px;
        font-weight: bold;
        transition: 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(217,108,143,0.3);
    }

    .btn-regresar:hover{
        background: #c4587b;
        transform: scale(1.08);
        color: white;
    }

    .titulo-grafica{
        font-size: 28px;
        font-weight: bold;
        color: #b84f74;
        margin-bottom: 8px;
    }

    .subtitulo{
        color: #777;
        margin-bottom: 25px;
        font-size: 15px;
    }

    .canvas-container{
        background: #fafafa;
        border-radius: 20px;
        padding: 20px;
    }

</style>

<div class="container grafica-container">

    <div class="grafica-card">

        {{-- BOTÓN REGRESAR --}}
        <a href="{{ route('usuarios.index') }}" class="btn-regresar">
            ✕
        </a>

        <h2 class="titulo-grafica">
            📊 Usuarios por Municipio
        </h2>

        <p class="subtitulo">
            Visualización de registros de usuarios agrupados por municipio.
        </p>

        <div class="canvas-container">
            <canvas id="graficaMunicipio"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const Municipios = @json($usuarios->pluck('Municipio'));
    const totales = @json($usuarios->pluck('total'));

    new Chart(document.getElementById('graficaMunicipio'), {

        type: 'bar',

        data: {
            labels: Municipios,

            datasets: [{

                label: 'Usuarios registrados',

                data: totales,

                backgroundColor: [
                    '#d96c8f',
                    '#e89bb3',
                    '#f3bfd0',
                    '#c4587b',
                    '#b84f74'
                ],

                borderRadius: 10,
                borderWidth: 0

            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#eeeeee'
                    }
                },

                x: {
                    grid: {
                        display: false
                    }
                }

            }

        }

    });

</script>

@endsection
