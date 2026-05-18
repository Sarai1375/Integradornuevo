<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Usuarios</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Reporte de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $usuario)
            <tr>
                <td>{{ $usuario->Nombre }}</td>
                <td>{{ $usuario->Ape_pat }}</td>
                <td>{{ $usuario->Ape_mat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
