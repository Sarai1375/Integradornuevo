@extends('cpanel.app')

@section('title', 'Encuesta de Satisfacción')

@section('content')

<h2 style="color:#c41e3a; margin-bottom:15px;">
    📝 Encuesta de Satisfacción
</h2>

<p style="margin-bottom:25px;">
    Tu opinión es muy importante para mejorar nuestro servicio de
    <strong>venta de rosas por mayoreo "Javier Dominguez"</strong>.
    <br>
    Esta encuesta es únicamente con fines de mejora continua.
</p>

<form>

    <!-- PREGUNTA 1 -->
    <div style="margin-bottom:20px;">
        <label><strong>1. ¿Cómo calificarías la calidad de la rosa recibida?</strong></label><br>
        <select style="width:100%; padding:8px;">
            <option value="">Selecciona una opción</option>
            <option>Excelente</option>
            <option>Buena</option>
            <option>Regular</option>
            <option>Mala</option>
        </select>
    </div>

    <!-- PREGUNTA 2 -->
    <div style="margin-bottom:20px;">
        <label><strong>2. ¿Qué tipo de servicio prefieres para realizar tu compra?</strong></label><br>
        <input type="radio" name="servicio" id="linea">
        <label for="linea">Servicio en línea</label><br>

        <input type="radio" name="servicio" id="punto">
        <label for="punto">Compra en punto de venta / negocio</label>
    </div>

    <!-- PREGUNTA 3 -->
    <div style="margin-bottom:20px;">
        <label><strong>3. ¿Qué tamaño de rosa prefieres para tu negocio?</strong></label><br>
        <select style="width:100%; padding:8px;">
            <option value="">Selecciona una opción</option>
            <option>Tallo corto</option>
            <option>Tallo mediano</option>
            <option>Tallo largo</option>
            <option>Indistinto</option>
        </select>
    </div>

    <!-- PREGUNTA 4 -->
    <div style="margin-bottom:20px;">
        <label><strong>4. ¿Con qué frecuencia compras rosas por mayoreo?</strong></label><br>
        <select style="width:100%; padding:8px;">
            <option value="">Selecciona una opción</option>
            <option>Semanalmente</option>
            <option>Quincenalmente</option>
            <option>Mensualmente</option>
            <option>Solo en temporadas especiales</option>
        </select>
    </div>

    <!-- PREGUNTA 5 -->
    <div style="margin-bottom:20px;">
        <label><strong>5. ¿El precio ofrecido te parece adecuado para compra por mayoreo?</strong></label><br>
        <input type="radio" name="precio" id="precio_si">
        <label for="precio_si">Sí</label><br>

        <input type="radio" name="precio" id="precio_no">
        <label for="precio_no">No</label>
    </div>

    <!-- PREGUNTA 6 -->
    <div style="margin-bottom:20px;">
        <label><strong>6. ¿Qué color de rosa compras con mayor frecuencia?</strong></label><br>
        <select style="width:100%; padding:8px;">
            <option value="">Selecciona una opción</option>
            <option>Roja</option>
            <option>Blanca</option>
            <option>Rosa</option>
            <option>Amarilla</option>
            <option>Mixta</option>
        </select>
    </div>

    <!-- PREGUNTA 7 -->
    <div style="margin-bottom:20px;">
        <label><strong>7. Comentarios o sugerencias para mejorar nuestro servicio</strong></label><br>
        <textarea rows="4" style="width:100%; padding:8px;"></textarea>
    </div>

    <!-- BOTÓN -->
    <button type="submit"
        style="
            background:#c41e3a;
            color:white;
            padding:12px 25px;
            border:none;
            border-radius:6px;
            font-weight:bold;
            cursor:pointer;
        ">
        Enviar encuesta
    </button>

</form>

@endsection
