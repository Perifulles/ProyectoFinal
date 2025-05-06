<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cañones del Júcar - Inicio</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Montserrat', sans-serif;
    }

    .background {
      background-image: url("./img/Pare trasera barco.jpg");
      background-size: cover;
      background-position: center;
      height: 100%;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      position: relative;
      backdrop-filter: blur(0.8px);
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .button-container {
      position: relative;
      z-index: 2;
      text-align: center;
    }

    .button {
      background: #ffffffcc;
      color: #003300;
      border: 2px solid #004d00;
      padding: 18px 50px;
      margin: 20px;
      font-size: 24px;
      font-weight: bold;
      border-radius: 12px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    .button:hover {
      background: #dfffe0;
      transform: scale(1.05);
    }

    .corner-link {
      position: absolute;
      bottom: 20px;
      right: 20px;
      z-index: 2;
    }

    .corner-link a {
      background: #ffffffcc;
      color: #004d00;
      padding: 12px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      border: 2px solid #004d00;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .corner-link a:hover {
      background: #cceac7;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="background">
    <div class="overlay"></div>
    <div class="button-container">
      <a href="subirexcell.php" class="button">Embarques</a>
      <a href="cierres.php" class="button">Cierres</a>
    </div>
    <div class="corner-link">
      <a href="https://suaventura.com" target="_blank">Visita Suaventura</a>
    </div>
  </div>
</body>
</html>
