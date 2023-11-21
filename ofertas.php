<?php
session_start();

// Define la función para conectar a la base de datos
function conectarBaseDatos()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bubbles_db";

    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (!$link) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $link;
}

// Define la función para verificar si el usuario es un administrador
function esAdmin()
{
    return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el usuario es un administrador antes de realizar acciones de administración
    if (esAdmin()) {
        $link = conectarBaseDatos();

        $titulo = mysqli_real_escape_string($link, $_POST['titulo']);
        $descripcion = mysqli_real_escape_string($link, $_POST['descripcion']);
        $puntos = (int)$_POST['puntos'];

        $query = "INSERT INTO promo (titulo, descripcion, puntos_requeridos) VALUES ('$titulo', '$descripcion', $puntos)";

        if (mysqli_query($link, $query)) {
            echo "Oferta agregada con éxito.";
        } else {
            echo "Error al agregar oferta: " . mysqli_error($link);
        }

        mysqli_close($link);
    } else {
        echo "Acceso no autorizado.";
    }
}

// Obtiene las ofertas desde la base de datos
$link = conectarBaseDatos();
$result = mysqli_query($link, "SELECT * FROM promo");
mysqli_close($link);
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
            font-family: sans-serif;
            color: black;
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

        h1,
        h2,
        h3 {
            color: black;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
        }

        .container {
            margin-top: 150px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
    <title>Ofertas por Puntos</title>
</head>

<body>
    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
        </center>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Ofertas por Puntos de Cliente Regular</h1>
                <ul>
                    <?php while ($row = mysqli_fetch_array($result)) : ?>
                        <li>
                            <h3><?= $row['titulo'] ?></h3>
                            <p><?= $row['descripcion'] ?></p>
                            <p>Puntos Requeridos: <?= $row['puntos_requeridos'] ?></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php if (esAdmin()) : ?>
                <div class="col-md-4">
                    <h2>Administración de Ofertas</h2>
                    <form method="POST" action="index.php">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="puntos">Puntos Requeridos:</label>
                            <input type="number" name="puntos" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Oferta</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
