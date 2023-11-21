<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>BUBBLES</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overpass&display=swap">
    <style>
        body {
            font-family: 'Overpass', sans-serif;
            font-size: 100%;
            color: #1b262c;
            margin: 0;
            background-image: url(Images/loginfondo.jpg);
            background-position: center;
            background-size: cover; /* Evita que la imagen de fondo se repita y cubre todo el fondo */
            height: 100vh;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #contenedor {
            display: flex;
            max-width: 900px; /* Ajusta según sea necesario */
            width: 100%;
            box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.15);
            border-radius: 5px;
            overflow: hidden;
        }

        #logo-columna {
            background-color: #0f4c75;
            padding: 20px;
            text-align: center;
        }

        #logo {
            max-width: 100%;
            height: auto;
        }

        #body {
            background-color: rgba(0, 0, 0, 0.75); /* Fondo más oscuro */
            flex: 1; /* El contenido se expandirá para llenar el espacio restante */
            padding: 30px;
            color: #bbe1fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #bbe1fa;
        }

        form {
            margin-top: 20px;
            width: 100%; /* Ocupa el 100% del ancho del contenedor */
            max-width: 400px; /* Ancho máximo del formulario */
        }

        label {
            color: #bbe1fa;
        }

        input {
            font-family: 'Overpass', sans-serif;
            font-size: 110%;
            color: #1b262c;
            display: block;
            width: 100%;
            height: 40px;
            margin-bottom: 10px;
            padding: 5px 5px 5px 10px;
            box-sizing: border-box;
            border: none;
            border-radius: 3px;
            background-color: #fff;
        }

        input::placeholder {
            color: #E4E4E4;
        }

        input[type="submit"] {
            background-color: #bbe1fa;
            color: #1b262c;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0f4c75;
        }

        .pie-form {
            font-size: 90%;
            text-align: center;
            margin-top: 15px;
        }

        .pie-form a {
            display: block;
            text-decoration: none;
            color: #bbe1fa;
            margin-bottom: 3px;
        }

        .pie-form a:hover {
            color: #0f4c75;
        }
    </style>
</head>

<body>
    <div id="contenedor">
        <div id="logo-columna">
            <img id="logo" src="Images/bubbles.png" alt="Logo de la empresa">
        </div>
        <div id="body">
            <h1>INICIO DE SESIÓN</h1>
            <form action="login.php" method="POST">
                <label>Usuario:</label>
                <input type="text" name="username" placeholder="Usuario" required><br><br>
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="Contraseña" required><br><br>

                <!-- Nuevo combobox para seleccionar el tipo de cuenta -->
                <label>Tipo de cuenta:</label>
                <select name="account_type">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select><br><br>

                <input type="submit" value="INGRESAR">
            </form>
            <?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bubbles_db";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $dbpassword, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Definir la tabla a consultar
    $table_name = "usuario_cliente";

    // Verificar el tipo de cuenta seleccionado (usuario o administrador)
    $account_type = "cliente";

    // Redirigir al panel de administrador si se selecciona "administrador"
    if ($_POST["account_type"] == "admin") {
        $table_name = "usuario_administrativo";
        $account_type = "admin";
    }

    // Consultar la base de datos para verificar las credenciales del usuario
    $sql = "SELECT * FROM $table_name WHERE Nombre = '$username'";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontró un usuario con esas credenciales
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verificar la contraseña utilizando password_verify
        if (password_verify($password, $row['Contraseña'])) {
            // Iniciar sesión
            session_start();
            $_SESSION["username"] = $username;

            // Redirigir al usuario según el tipo de cuenta
            if ($account_type == 'admin') {
                header("Location: admin.php"); // Redireccionar al panel de administrador
            } else {
                header("Location: index.php"); // Redireccionar a la página de inicio
            }
            exit();
        } else {
            // Mostrar un mensaje de error si la contraseña es incorrecta
            echo "<center><p>Usuario o contraseña incorrecto. Intente de nuevo.</p></center>";
        }
    } else {
        // Mostrar un mensaje de error si no se encontró un usuario con ese nombre
        echo "<center><p>Usuario o contraseña incorrecto. Intente de nuevo.</p></center>";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
            <div class="pie-form">
                <a href="#">¿Perdiste tu contraseña?</a>
                <a href="register.php">¿No tienes Cuenta? Regístrate</a>
            </div>
        </div>
    </div>
</body>

</html>
