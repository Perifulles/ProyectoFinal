<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar lista</title>
    <style>
        body {
            font-size: 1.5em;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            text-align: center;
            padding-top: 100px;
        }

        input[type="number"] {
            font-size: 1.2em;
            padding: 10px;
            width: 200px;
            margin-bottom: 20px;
        }

        button {
            font-size: 1.2em;
            padding: 10px 20px;
        }

        h2 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h2>Introduce el número de la lista </h2>
    <h3 style="font-size: 16px; font-weight: normal;">
    (1 => el último en ser descargado, 2 => el penúltimo...)
</h3>
    <form method="GET" action="principal.php">
        <input type="number" name="lista" min="1" required placeholder="Ej: 1">
        <br>
        <button type="submit">Acceder</button>
    </form>
</body>
</html>
