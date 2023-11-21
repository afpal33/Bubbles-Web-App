<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bubbles_db";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario de la sesión
$username = $_SESSION["username"];

// Consultar la base de datos para verificar los permisos de administrador
$sql = "SELECT * FROM usuario_administrativo WHERE Nombre = '$username'";
$result = mysqli_query($conn, $sql);

// Verificar si se encontró un usuario con permisos de administrador
if (mysqli_num_rows($result) != 1) {
    // El usuario no tiene permisos de administrador, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Función para mostrar usuarios en la tabla
function mostrarUsuarios($conn) {
    $sql = "SELECT ID_usuario, Nombre, Puntos_compra_acumulados FROM usuario_cliente";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID_usuario"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["Puntos_compra_acumulados"] . "</td>";
            echo '<td><a href="admin.php?accion=addPoints&ID_usuario=' . $row["ID_usuario"] . '">Agregar Puntos</a> | <a href="admin.php?accion=reducePoints&ID_usuario=' . $row["ID_usuario"] . '">Reducir Puntos</a></td>';
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
    }
}

// Función para realizar operaciones de ABM
function gestionarUsuarios($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Procesa la acción según la URL
        $accion = $_GET["accion"];
        $idUsuario = $_GET["ID_usuario"];

        if ($accion == "addPoints") {
            // Lógica para agregar puntos a un usuario
            // Puedes ajustar la cantidad de puntos a agregar según tus necesidades
            $puntosAAgregar = 10;

            $sql = "UPDATE usuario_cliente SET Puntos_compra_acumulados = Puntos_compra_acumulados + $puntosAAgregar WHERE ID_usuario=$idUsuario";
            if ($conn->query($sql) === TRUE) {
                echo "Puntos agregados exitosamente.";
            } else {
                echo "Error al agregar puntos: " . $conn->error;
            }
        } elseif ($accion == "reducePoints") {
            // Lógica para reducir puntos a un usuario
            // Puedes ajustar la cantidad de puntos a reducir según tus necesidades
            $puntosAReducir = 5;

            $sql = "UPDATE usuario_cliente SET Puntos_compra_acumulados = GREATEST(0, Puntos_compra_acumulados - $puntosAReducir) WHERE ID_usuario=$idUsuario";
            if ($conn->query($sql) === TRUE) {
                echo "Puntos reducidos exitosamente.";
            } else {
                echo "Error al reducir puntos: " . $conn->error;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>BUBBLES</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">
    <style>
         html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

body {
  background-color: #87CEEB; /* Azul celeste */
  font-family: sans-serif;
  color: black; /* Texto en negro */
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

#logo {
  max-width: 100%;
  height: auto;
  width: 150px;
  height: 50px;
}

#pillNav2 {
  height: 45px;
  width: 900px;
  margin: 0 auto;
}

#button {
  margin-right: 20px;
}

#welcome {
  font-size: 25px;
  color: black;
}

#button2 {
  margin-left: 20px;
}

h1 {
    color: black; /* Texto en negro */
    font-size: 36px; /* Tamaño de fuente */
    font-weight: bold; /* Fuente en negrita */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra de texto */
    text-align: center; /* Texto centrado */
    margin-bottom: 10px; /* Margen inferior */
  }

footer {
  font-family: "Raleway", sans-serif;
  background-color: black;
  color: #1E90FF; /* Azul claro */
  position: static;
  left: 0;
  bottom: 0;
  width: 100%;
  padding: 20px;
  text-align: center;
}

        .google-maps {
            position: relative;
            padding-bottom: 30%;
            padding-left: 20%;
            height: 0;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        #title,
        #subtitle {
            font-size: 60px;
        }

        .google-maps iframe {
            position: absolute;
            width: 60% !important;
            height: 50% !important;
        }

        #body {
            background-color: white;
            width: 95%; /* Reduje el ancho para dejar espacio alrededor */
            border: 10px solid #ddd; /* Cambié el grosor del borde y el color */
            border-radius: 15px; /* Añadí un radio a las esquinas */
            padding: 20px; /* Ajusté el relleno */
            margin: 20px auto; /* Centré el elemento en la página */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Añadí una suave sombra */
        }


        
    </style>
<body>

    <div >
        <h2>ABM de Usuarios</h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="accion" value="alta"> <!-- Puedes cambiar esta acción según tus necesidades -->

            <!-- Añade campos para ingresar información del usuario -->
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="puntos_cliente_regular">Puntos Cliente Regular:</label>
            <input type="text" name="puntos_cliente_regular" required>

            <button type="submit">Agregar Usuario</button>
        </form>

        <!-- Tabla de usuarios -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Puntos Cliente Regular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Muestra la tabla de usuarios
                    mostrarUsuarios($conn);
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>

<?php
    // Gestionar usuarios después de enviar el formulario
    gestionarUsuarios($conn);

    // Cierra la conexión a la base de datos al finalizar
    $conn->close();
?>
