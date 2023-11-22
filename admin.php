<?php
session_start();

// Función para conectar a la base de datos
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

// Función para verificar si el usuario es un administrador
function esAdmin()
{
    return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
}

// Obtener la lista de usuarios_cliente desde la base de datos
$link = conectarBaseDatos();
$result_cliente = mysqli_query($link, "SELECT ID_usuario, Nombre, Puntos_compra_acumulados FROM usuario_cliente");

// Obtener la lista de usuarios_administrativos desde la base de datos
$result_admin = mysqli_query($link, "SELECT ID_UA, Nombre, CI FROM Usuario_administrativo");
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

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <title>Administrador</title>
</head>
<body>
    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
        </center>
    </header>
    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- Tabla de usuario_cliente -->
        <h2>Usuarios Cliente</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result_cliente)) : ?>
                        <tr>
                            <td><?= $row['ID_usuario'] ?></td>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['Puntos_compra_acumulados'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de usuario_administrativo -->
        <h2>Usuarios Administrativos</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result_admin)) : ?>
                        <tr>
                            <td><?= $row['ID_UA'] ?></td>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['CI'] ?></td>
                            <td>
                                <a href="editar_admin.php?id=<?= $row['ID_UA'] ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar nuevo usuario_administrativo -->
        <h2>Agregar Usuario Administrativo</h2>
        <form method="POST" action="admin.php">
            <div class="form-group">
                <label for="nombre_admin">Nombre:</label>
                <input type="text" name="nombre_admin" required>
            </div>

            <div class="form-group">
                <label for="contrasena_admin">Contraseña:</label>
                <input type="password" name="contrasena_admin" required>
            </div>

            <div class="form-group">
                <label for="ci_admin">CI:</label>
                <input type="text" name="ci_admin" required>
            </div>

            <button type="submit" name="agregar_admin" class="btn btn-primary">Agregar Administrativo</button>
        </form>
    </div>
</body>
</html>

<?php
// Procesar formulario para agregar nuevo usuario_administrativo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_admin'])) {
    $nombre_admin = mysqli_real_escape_string($link, $_POST['nombre_admin']);
    $contrasena_admin = mysqli_real_escape_string($link, $_POST['contrasena_admin']);
    $ci_admin = mysqli_real_escape_string($link, $_POST['ci_admin']);

    // Insertar en la base de datos
    $query = "INSERT INTO Usuario_administrativo (Nombre, Contraseña, CI) VALUES ('$nombre_admin', '$contrasena_admin', '$ci_admin')";

    if (mysqli_query($link, $query)) {
        echo "<script>alert('Usuario administrativo agregado con éxito.');</script>";
        echo "<script>window.location.replace('admin.php');</script>";
    } else {
        echo "<script>alert('Error al agregar usuario administrativo: " . mysqli_error($link) . "');</script>";
    }
}

mysqli_close($link);
?>
