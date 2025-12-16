<!DOCTYPE html>
<html>
<head>
    <title>Listado de Participantes</title>

    <style>
        body { background: #111; color: #fff; font-family: Arial; padding: 20px; }
        
        .contenedor {
            width: 500px;
            margin: auto;
            background: #222;
            padding: 20px;
            border-radius: 10px;
        }

        h1 { text-align: center; }

        ul { list-style: none; padding: 0; }

        li {
            padding: 10px;
            border-bottom: 1px solid #444;
            font-size: 18px;
        }

        a {
            color: #4db8ff;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="contenedor">
    <a href="{{ route('rifa.index') }}">&larr; Regresar a la ruleta</a>

    <h1>📋 Participantes</h1>

    <ul>
        @foreach($participantes as $p)
            <li>{{ $p->nombre }}</li>
        @endforeach
    </ul>
</div>

</body>
</html>
