<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Sistema' }}</title>

    <style>
        body{
            margin:0;
            padding:0;
            background:#f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container{
            max-width:600px;
            margin:30px auto;
            background:#ffffff;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        .header{
            background:linear-gradient(135deg,#8b0000,#c40000);
            color:white;
            padding:25px;
            text-align:center;
            font-size:22px;
            font-weight:bold;
        }

        .body{
            padding:30px;
            color:#333;
        }

        .code-box{
            font-size:24px;
            letter-spacing:5px;
            text-align:center;
            padding:15px;
            margin:20px 0;
            background:#f8f8f8;
            border-radius:10px;
            border:1px dashed #b30000;
            font-weight:bold;
            color:#b30000;
        }

        .btn{
            display:inline-block;
            background:#b30000;
            color:#fff !important;
            padding:12px 20px;
            border-radius:25px;
            text-decoration:none;
            margin-top:20px;
        }

        .footer{
            text-align:center;
            font-size:12px;
            color:#777;
            padding:20px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        {{ $header ?? 'Notificación del Sistema' }}
    </div>

    <div class="body">
        @yield('content')
    </div>

    <div class="footer">
        © {{ date('Y') }} Sistema de Usuarios - Todos los derechos reservados
    </div>

</div>

</body>
</html>