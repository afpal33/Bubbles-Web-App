<?php
// Inicia la sesión
session_start();

// Función para conectar a la base de datos
function conectarBaseDatos()
{
    $servername = "localhost";
    $username = "root";
    $password = "marco1211";
    $dbname = "bubbles_db";

    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (!$link) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $link;
}

// Obtener el nombre de usuario y puntos de cliente regular desde la base de datos
function obtenerDatosUsuario($idUsuario)
{
    $link = conectarBaseDatos();

    $query = "SELECT Nombre, puntos_compra_acumulados, Correo, Telefono, Direccion FROM usuario_cliente WHERE id_usuario = $idUsuario";
    $result = mysqli_query($link, $query);

    if ($result) {
        $userData = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($link);
        return $userData;
    } else {
        echo "Error al obtener datos de usuario: " . mysqli_error($link);
        mysqli_close($link);
        return null;
    }
}

// Datos de ejemplo del usuario (pueden ser recuperados de la base de datos después del inicio de sesión)
$id_usuario = $_SESSION['ID_usuario']; // Reemplazar con el ID de usuario real después del inicio de sesión
$userData = obtenerDatosUsuario($id_usuario); // Corregido el nombre de la variable
$link = conectarBaseDatos();

// Verifica si el usuario está autenticado
$usuarioAutenticado = isset($userData['Nombre']);

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
            background-color: aliceblue;
            border-radius: 10vh;
            align-items: center;
            text-align: center;
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
        .cont{
            background-color: #1E90FF;
            margin-top: 4vh;
            margin-bottom: 4vh;
            color: aliceblue;
            font-size: 4vh;
            border-radius: 2vh;
            text-align: center;
        }
        .cont2{
            margin-top: 4vh;
            margin-bottom: 4vh;
            color: #333;
            font-size: 4vh;
            border-radius: 2vh;
            text-align: center;
            align-items: center;
        }
        .additional-section {
        margin-left: 10%;
        padding-top: 4vh;
        width: 800px;
        height: 300px;
        background-color: #1E90FF;
        text-align: center;
        align-items: center;
        border-radius: 10vh;
        flex-grow: 0;
        
    }
    .lead2{
        font-size: 10vh;
        color: aliceblue;
    }
    .lead3{
        font-size: 2vh;
        color: aliceblue;
    }
    </style>
    <title>Perfil de Usuario</title>
</head>

<body>
    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
            <a href="index.php" class="btn btn-primary btn-lg rounded-5 active" role="button">Menú</a>
        </center>
    </header>
    <div class="container">
        <?php if ($usuarioAutenticado) : ?>
            <br>
            <h1>DATOS CLIENTE</h1>
            <div class="user-info">
                <img src="Images/lobo.jpg" alt="Foto de perfil"> <!-- Reemplazar con la ruta real de la imagen -->
                <div>
                    <div class="cont">
                        <h1 class="display-4"></h1></h1></h1></h1></h1></h1><?php echo $userData['Nombre']; ?></h1>
                    </div>
                    <div class="cont2">
                        <p class="lead">Correo: <?php echo $userData['Correo']; ?></p>
                    </div>
                    <div class="cont2">
                        <p class="lead">Telefono: <?php echo $userData['Telefono']; ?></p>
                    </div>
                    <div class="cont2">
                        <p class="lead">Direccion: <?php echo $userData['Direccion']; ?></p>
                    </div>
                </div>
                <div class="additional-section">
                <!-- Nueva sección a la derecha -->
                    <p class="lead2"><?php echo $userData['puntos_compra_acumulados']; ?></p>
                    <p class="lead3">Puntos</p>
                 </div>

            <!-- Tabla de usuario_cliente -->
        
            </div>
            <h2>HISTORIAL SERVICIOS</h2>
            <br>
            <br>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id servicio</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Costo</th>
                        <th>Puntos</th>
                        <th>Sucursal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_user=$id_usuario;
                    $query = "SELECT id_serv, Descripcion, Fecha, Costo, Puntos_obtenidos, Sucursal FROM servicio_usuario WHERE id_usuario = $id_user";
                    $result_serv = mysqli_query($link, $query);
                    // Modificar la consulta para obtener también correo y teléfono
                    //$result_cliente = mysqli_query($link, "SELECT id_serv, Descripcion, Fecha, Costo, Puntos_obtenidos, Sucursal FROM servicio_usuario WHERE id_usuario = $id_usuario");
                    while ($row = mysqli_fetch_array($result_serv)) :
                    ?>
                        <tr>
                            <td><?= $row['id_serv'] ?></td>
                            <td><?= $row['Descripcion'] ?></td>
                            <td><?= $row['Fecha'] ?></td>
                            <td><?= $row['Costo'] ?></td>
                            <td><?= $row['Puntos_obtenidos'] ?></td>
                            <td><?= $row['Sucursal'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
        <?php else : ?>
            <p>Usuario no autenticado. Debes iniciar sesión.</p>
        <?php endif; ?>
    </div>
    
</body>

</html>
