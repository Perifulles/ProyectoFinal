<?php
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excel']) && $_FILES['excel']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['excel']['tmp_name'];
        $destino = __DIR__ . '/excels/lista reservas (1).xlsx';

        if (!is_dir(__DIR__ . '/excels')) {
            mkdir(__DIR__ . '/excels', 0777, true);
        }

        if (move_uploaded_file($tmp, $destino)) {
            header("Location: embarques.php?subida=1");
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
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .formulario h1 {
      margin-bottom: 25px;
      font-size: 26px;
      color: #333;
    }

    input[type="file"] {
      margin-bottom: 20px;
    }

    button {
      padding: 12px 24px;
      font-size: 16px;
      background-color: #006600;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
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
    }

    .boton-volver {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: #cc0000; /* Rojo fuerte */
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
    display: inline-block;
    }

    .boton-volver:hover {
    background-color: #ff1a1a; /* Rojo más claro al pasar el ratón */
    }



    .boton-flecha:hover {
    background-color: #0099ff;
    }

    a.boton-flecha {
    text-decoration: none;
    display: inline-block;
    }

  </style>
</head>
<body>
  <form class="formulario" action="" method="POST" enctype="multipart/form-data">
    <h1>Subir Lista de Reservas</h1>
    <input type="file" name="excel" accept=".xls,.xlsx" required><br>
    <button type="submit">Subir Excel</button>
  </form>

  <?php if (!empty($mensaje)) : ?>
    <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
  <?php endif; ?>

  <a href="embarques.php" class="boton-flecha">Pasar con el último embarque →</a>
  <a href="index.php" class="boton-volver">← Volver</a>

</body>
</html>
