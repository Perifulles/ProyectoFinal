<?php
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excel']) && $_FILES['excel']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['excel']['tmp_name'];
        $destino = __DIR__ . '/excels/cierre.xlsx';

        if (!is_dir(__DIR__ . '/excels')) {
            mkdir(__DIR__ . '/excels', 0777, true);
        }

        if (move_uploaded_file($tmp, $destino)) {
            header("Location: cierre.php");
            exit;
        } else {
            $mensaje = "❌ Error al guardar el archivo.";
        }
    } else {
        $mensaje = "⚠️ No se seleccionó ningún archivo válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Subir Lista de Reservas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url("./img/Panoramica Barco.jpg");
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .formulario {
      background: rgba(255, 255, 255, 0.97);
      padding: 50px;
      border-radius: 18px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      width: 320px;
    }

    .formulario h1 {
      margin-bottom: 30px;
      font-size: 24px;
      color: #333;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 20px;
      color: #444;
    }

    select,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      background-color: #f9f9f9;
    }

    input[type="file"] {
      background-color: white;
    }

    button {
      margin-top: 25px;
      padding: 12px 28px;
      font-size: 16px;
      background-color: #006600;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #009900;
    }

    .mensaje {
      margin-top: 20px;
      background: rgba(255, 255, 255, 0.9);
      padding: 10px 20px;
      border-radius: 8px;
      color: #cc0000;
      font-weight: bold;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .boton-flecha {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #0066cc;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px 20px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: background-color 0.3s;
      text-decoration: none;
    }

    .boton-flecha:hover {
      background-color: #0099ff;
    }

    .boton-volver {
      position: fixed;
      bottom: 20px;
      left: 20px;
      background-color: #cc0000;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 12px 20px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: background-color 0.3s;
      text-decoration: none;
    }

    .boton-volver:hover {
      background-color: #ff1a1a;
    }

  </style>
</head>
<body>

  <form class="formulario" action="" method="POST" enctype="multipart/form-data">
    <h1>Subir Lista de Reservas del día</h1>

    <label for="excel">Archivo Excel:</label>
    <input type="file" name="excel" id="excel" accept=".xls,.xlsx" required>

    <button type="submit">Subir Lista de reservas</button>
  </form>

  <?php if (!empty($mensaje)) : ?>
    <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
  <?php endif; ?>

  <a href="cierre.php" class="boton-flecha">Pasar con el último cierre →</a>
  <a href="../index.php" class="boton-volver">← Volver</a>
</body>
</html>


