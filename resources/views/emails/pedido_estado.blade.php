<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Actualización de tu pedido</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f7f7f7; padding:20px;">

    <div style="max-width:600px; margin:auto; background:white; border-radius:10px; overflow:hidden;">

        <!-- HEADER -->
        <div style="background:#dc3545; color:white; padding:20px; text-align:center;">
            <h2>🌹 Invernaderos Javier Domínguez</h2>
        </div>

        <!-- BODY -->
        <div style="padding:25px;">

            <h3>Hola 👋</h3>

            <p>Tu pedido <strong>#{{ $pedido->Id_ped }}</strong> ha sido actualizado.</p>

            <p style="font-size:16px;">
                Nuevo estado:
            </p>

            <div style="padding:10px 15px; background:#f1f1f1; border-left:5px solid #dc3545; font-size:18px;">
                <strong>{{ $estado }}</strong>
            </div>

            <br>

            <p>
                📅 Fecha del pedido: {{ $pedido->Fecha_realizada }}
            </p>

            <p>
                💰 Total: ${{ number_format($pedido->Total_pedido,2) }}
            </p>

            <br>

            <p style="color:#666;">
                Gracias por tu compra 🌹<br>
                Equipo de Invernaderos Javier Domínguez
            </p>

        </div>

        <!-- FOOTER -->
        <div style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#666;">
            Este es un correo automático, no respondas a este mensaje.
        </div>

    </div>

</body>
</html>