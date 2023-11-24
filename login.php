<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>BUBBLES</title>
    <style>
        html {
            position: relative;
            min-height: 100%;
            color: white;
        }

        body {
            background-color: aqua;
            background-position: 100%;
            font-family: sans-serif;
            margin: 0;
            height: 100%;
            min-height: 100%;
        }

        h1 {
            color: white;
        }

        footer {
            font-family: "Raleway", sans-serif;
            background-color: rgb(0, 9, 24);
            color: rgb(146, 146, 146);
            position: static;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #body {
            background-color: rgba(0, 0, 0, 0.651);
            width: 99%;
            border: 15px;
            padding: 30px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div id="body">
        <center>
            <br>
            <br>
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <label style="color:white">Usuario:</label>
                <input type="text" name="username"><br><br>
                <label style="color:white">Contraseña:</label>
                <input type="password" name="password"><br><br>
                <input class="btn btn-primary btn-lg rounded-5 active" type="submit" value="Login">
            </form>
        </center>

        <?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "bubbles_db";
$username = "root";
<<<<<<< Updated upstream
$password = "";
=======
$password = "marco1211";
$dbname = "bubbles_db";
>>>>>>> Stashed changes

// Intentamos establecer la conexión a la base de datos
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Definimos las variables y las inicializamos con valores vacíos
$username = $password = "";
$username_err = $password_err = "";

// Procesamos los datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
<<<<<<< Updated upstream
    // Validar el nombre de usuario
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, ingresa un nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }
=======

    // Obtener los valores del formulario
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Consultar la base de datos para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuario_cliente WHERE Nombre = '$username' AND Contrasena = '$password'";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontró un usuario con esas credenciales
    if ($result && mysqli_num_rows($result) == 1) {
        // Iniciar sesión
        session_start();
        $_SESSION["username"] = $username;

        // Obtener el ID del usuario y establecer la variable de sesión
        $id_usuario = obtenerIdUsuario($username);
        $_SESSION['ID_usuario'] = $id_usuario;

        // Redirigir al usuario a la página de inicio
        header("Location: index.php");
        exit();
    } else {
        // Verificar en la tabla de usuario administrativo
        $sql_admin = "SELECT * FROM usuario_administrativo WHERE Nombre = '$username' AND Contrasenha = '$password'";
        $result_admin = mysqli_query($conn, $sql_admin);
>>>>>>> Stashed changes

    // Validar la contraseña
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, ingresa una contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Verificar si no hay errores antes de realizar la consulta a la base de datos
    if (empty($username_err) && empty($password_err)) {
        // Consulta a la base de datos para obtener el hash de la contraseña
        $sql = "SELECT ID_usuario, Nombre, Contrasena FROM usuario_cliente WHERE Nombre = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Asignamos los parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Asignamos los valores
            $param_username = $username;
            // Intentamos ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                // Verificar si se encontró un usuario con ese nombre
                if (mysqli_num_rows($result) == 1) {
                    // Obtener la contraseña almacenada en la base de datos
                    $row = mysqli_fetch_assoc($result);
                    $hash = $row["Contrasena"];

                    // Verificar la contraseña usando password_verify
                    if (password_verify($password, $hash)) {
                        // Iniciar sesión
                        session_start();
                        $_SESSION["username"] = $username;
                        // Redirigir al usuario a la página de inicio
                        header("Location: index.php");
                        exit();
                    } else {
                        // Mostrar un mensaje de error si la contraseña no coincide
                        echo "<center><p>Usuario o contraseña incorrecto. Intente de nuevo.</p></center>";
                    }
                } else {
                    // Mostrar un mensaje de error si no se encontró un usuario con ese nombre
                    echo "<center><p>Usuario o contraseña incorrecto. Intente de nuevo.</p></center>";
                }
            } else {
                echo "Oops! Algo salió mal. Por favor, intenta de nuevo más tarde.";
            }
            // Cerramos la sentencia
            mysqli_stmt_close($stmt);
        }
    }
    // Cerramos la conexión a la base de datos
    mysqli_close($conn);
}
<<<<<<< Updated upstream
=======

// Función para obtener el ID del usuario
function obtenerIdUsuario($username)
{
    global $conn;
    $sql = "SELECT ID_usuario FROM usuario_cliente WHERE Nombre = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['ID_usuario'];
    } else {
        return null;
    }
}

// Función para obtener el ID del usuario administrativo
function obtenerIdUsuarioAdmin($username)
{
    global $conn;
    $sql = "SELECT ID_UA FROM usuario_administrativo WHERE Nombre = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['ID_UA'];
    } else {
        return null;
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
>>>>>>> Stashed changes
?>


    </div>

</body>

</html>
