@extends('cliente.app')

@section('title', 'Carrito')

@section('content')

<div class="container py-5">

    <div class="bg-white p-5 rounded-4 shadow-sm">

        <h2 class="text-danger mb-4">
            🛒 Mi carrito
        </h2>

        {{-- MENSAJES --}}

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif

        {{-- TABLA --}}

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-danger">

                    <tr>

                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($carrito as $item)

                        <tr>

                            {{-- IMAGEN --}}

                            <td>

                                @if($item->Imagen)

                                    <img src="{{ asset('storage/'.$item->Imagen) }}"
                                         width="90"
                                         height="90"
                                         style="object-fit:cover; border-radius:10px;">

                                @else

                                    <img src="{{ asset('images/inverna.jpg') }}"
                                         width="90"
                                         height="90"
                                         style="object-fit:cover; border-radius:10px;">

                                @endif

                            </td>

                            {{-- NOMBRE --}}

                            <td>

                                <strong>
                                    {{ $item->Nombre }}
                                </strong>

                            </td>

                            <td>

                    <div class="d-flex align-items-center gap-2">

                        {{-- DISMINUIR --}}

                        <form action="{{ route('carrito.disminuir', $item->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-danger btn-sm">

                                -

                            </button>

                        </form>

                        {{-- CANTIDAD --}}

                        <strong>

                            {{ $item->Cantidad }}

                        </strong>

                        {{-- AUMENTAR --}}

                        <form action="{{ route('carrito.aumentar', $item->id) }}"
                            method="POST">

                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-success btn-sm">

                                +

                            </button>

                        </form>

                    </div>

                </td>
                            {{-- PRECIO --}}

                            <td>

                                ${{ number_format($item->Precio, 2) }}

                            </td>

                            {{-- SUBTOTAL --}}

                            <td>

                                ${{ number_format($item->Subtotal, 2) }}

                            </td>

                            {{-- ELIMINAR --}}

                            <td>

                                <form action="{{ route('carrito.eliminar', $item->id) }}"
                                      method="POST">

                                    @csrf

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">

                                        🗑 Eliminar

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-4">

                                No hay productos en el carrito 🌹

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- TOTAL --}}

        <div class="mt-4 text-end">

            <h3>

                Total:
                <span class="text-danger">

                    ${{ number_format($total, 2) }}

                </span>

            </h3>

        </div>

        {{-- PAQUETES --}}

        <div class="mt-3">

            <h5>

                Total de paquetes:
                <span class="text-primary">

                    {{ $totalPaquetes }}

                </span>

            </h5>

            @if($totalPaquetes < 7)

                <div class="alert alert-danger mt-3">

                    ⚠ El pedido mínimo para envío es de
                    <strong>7 paquetes</strong>.

                </div>

            @else

                <div class="alert alert-success mt-3">

                    ✔ Tu pedido cumple con el mínimo requerido.

                </div>

            @endif

        </div>

        <hr class="my-4">

        {{-- FORMULARIO DE PAGO --}}

        <form action="{{ route('carrito.finalizar') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                {{-- FECHA ENTREGA --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Fecha de entrega

                    </label>

                    <input type="date"
                    name="Fecha_entrega"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                    required>

                </div>

                {{-- MÉTODO DE PAGO --}}

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Método de pago

                    </label>

                    <select name="MetodoPago"
                            id="MetodoPago"
                            class="form-select"
                            required>

                        <option value="">
                            -- Selecciona --
                        </option>

                        <option value="Efectivo">
                            💵 Efectivo
                        </option>

                        <option value="Transferencia">
                            🏦 Transferencia
                        </option>

                    </select>

                </div>

            </div>

            {{-- DIRECCIÓN --}}

            <div class="mb-3">

                <label class="form-label">

                    Dirección de entrega

                </label>

                <select class="form-select"
                        id="tipoDireccion">

                    <option value="registrada">

                        Usar dirección registrada

                    </option>

                    <option value="otra">

                        Usar otra dirección

                    </option>

                </select>

            </div>

            {{-- DIRECCIÓN REGISTRADA --}}

            <div class="mb-3"
                 id="direccionRegistrada">

                <textarea class="form-control"
                          rows="3"
                          readonly>{{ $usuario->Calle }} {{ $usuario->Numero }},
{{ $usuario->Municipio }},
{{ $usuario->Estado }},
CP {{ $usuario->CP }}</textarea>

            </div>

            {{-- OTRA DIRECCIÓN --}}

            <div class="mb-3 d-none"
                 id="otraDireccion">

                <textarea name="Direccion_entrega"
                          class="form-control"
                          rows="3"
                          placeholder="Escribe la dirección completa"></textarea>

            </div>

            {{-- TRANSFERENCIA --}}

            <div class="d-none"
                 id="transferenciaBox">

                <div class="alert alert-info">

                    <h5>
                        🏦 Datos bancarios
                    </h5>

                    <p class="mb-1">
                        Banco: BBVA
                    </p>

                    <p class="mb-1">
                        Cuenta: 1234567890
                    </p>

                    <p class="mb-1">
                        CLABE: 012345678901234567
                    </p>

                    <p class="mb-0">
                        Titular: Invernaderos Javier Domínguez
                    </p>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Comprobante de pago

                    </label>

                    <input type="file"
                           name="Comprobante_pago"
                           class="form-control"
                           accept="image/*">

                </div>

            </div>

            {{-- OBSERVACIONES --}}

            <div class="mb-3">

                <label class="form-label">

                    Observaciones

                </label>

                <textarea name="Observaciones"
                          class="form-control"
                          rows="3"></textarea>

            </div>

            {{-- BOTÓN --}}

            <button type="submit"
                    class="btn btn-success w-100 py-3 mt-3"

                    @if($totalPaquetes < 7)
                        disabled
                    @endif>

                ✅ Finalizar compra

            </button>

        </form>

    </div>

</div>

{{-- SCRIPT --}}

<script>

    const metodoPago =
        document.getElementById('MetodoPago');

    const transferenciaBox =
        document.getElementById('transferenciaBox');

    metodoPago.addEventListener('change', function () {

        if (this.value === 'Transferencia') {

            transferenciaBox.classList.remove('d-none');

        } else {

            transferenciaBox.classList.add('d-none');
        }

    });

    const tipoDireccion =
        document.getElementById('tipoDireccion');

    const otraDireccion =
        document.getElementById('otraDireccion');

    const direccionRegistrada =
        document.getElementById('direccionRegistrada');

    tipoDireccion.addEventListener('change', function () {

        if (this.value === 'otra') {

            otraDireccion.classList.remove('d-none');

            direccionRegistrada.classList.add('d-none');

        } else {

            otraDireccion.classList.add('d-none');

            direccionRegistrada.classList.remove('d-none');
        }

    });

</script>

@endsection