<?php
// Datos de ejemplo del usuario (pueden ser recuperados de la base de datos)
$nombreUsuario = "Usuario Ejemplo";
$correoUsuario = "usuario@example.com"; // Reemplazar con el correo real del usuario
$puntosClienteRegular = 150; // Obtén esta información de la base de datos
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #87CEEB; /* Azul celeste */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333; /* Cambié el color del texto a un tono más oscuro */
        }

        header {
            background-color: #1E90FF; /* Azul claro */
            box-shadow: 3px 3px 3px 5px rgba(0, 0, 0, 0.336);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 90px;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .container {
            margin-top: 150px;
        }

        h1,
        h2,
        h3 {
            color: #333; /* Cambié el color del texto a un tono más oscuro */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 30px; /* Añadí margen inferior para separar de otros elementos */
        }

        .user-info img {
            border-radius: 50%;
            margin-right: 20px;
            width: 150px; /* Ajusté el tamaño de la foto de perfil */
            height: 150px; /* Ajusté el tamaño de la foto de perfil */
        }

        .user-info div {
            max-width: 600px; /* Limité el ancho para que no ocupe todo el contenedor */
        }
    </style>
    <title>Perfil de Usuario</title>
</head>

<body>
    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
        </center>
    </header>
    <div class="container">
        <div class="user-info">
            <img src="Images/usuario.jpg" alt="Foto de perfil">
            <div>
                <h1 class="display-4"><?php echo $nombreUsuario; ?></h1> <!-- Utilicé una clase de Bootstrap para encabezado grande -->
                <p class="lead">Correo Electrónico: <?php echo $correoUsuario; ?></p> <!-- Utilicé una clase de Bootstrap para texto grande -->
                <p class="lead">Puntos de Cliente Regular: <?php echo $puntosClienteRegular; ?></p> <!-- Utilicé una clase de Bootstrap para texto grande -->
            </div>
        </div>
    </div>
</body>

</html>
