<?php
// Este formulario enviará los datos a tu archivo principal por POST.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Pasante</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 50px;
            font-size: 18px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 30px;
            margin-bottom: 30px;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.12);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
            font-size: 20px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 18px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Añadir nuevo pasante</h2>
    <form action="embarques.php?lista=1" method="POST">
        <input type="hidden" name="accion" value="insertarPasante">
        
        <label>Nombre:</label>
        <input type="text" name="pasante[nombre]" value="pasante">

        <label>Apellido 1:</label>
        <input type="text" name="pasante[apellido_1]" value="pasante">

        <label>Apellido 2:</label>
        <input type="text" name="pasante[apellido_2]" value="pasante">

        <label>Teléfono:</label>
        <input type="text" name="pasante[telefono]" value="+34666666666">

        <label>Adultos:</label>
        <input type="number" name="pasante[adultos]" value="0">

        <label>Niños:</label>
        <input type="number" name="pasante[ninos]" value="0">

        <label>Gratis:</label>
        <input type="number" name="pasante[gratis]" value="0">

        <input type="submit" value="➕ Añadir Pasante">
    </form>
</body>
</html>
