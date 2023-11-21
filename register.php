<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "bubbles_db";
$username = "root";
$password = "";

// Intentamos conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Habilitamos los errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Iniciamos la sesión
session_start();

// Si el usuario ya ha iniciado sesión, redirigimos a la página principal
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Definimos las variables y las inicializamos con valores vacíos
$username = $password = $confirm_password = $email = $phone = $address = "";
$username_err = $password_err = $confirm_password_err = $email_err = $phone_err = $address_err = "";

// Procesamos los datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar el nombre de usuario
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor, ingresa un nombre de usuario.";
    } else {
        // Preparamos una sentencia SELECT para comprobar si el nombre de usuario ya está en uso
        $sql = "SELECT ID_usuario FROM usuario_cliente WHERE Nombre = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Asignamos los parámetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Asignamos los valores
            $param_username = trim($_POST["username"]);

            // Intentamos ejecutar la sentencia
            if ($stmt->execute()) {
                // Si el nombre de usuario no está en uso, lo asignamos a la variable $username
                if ($stmt->rowCount() == 1) {
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Algo salió mal. Por favor, intenta de nuevo más tarde.";
            }
        }

        // Cerramos la sentencia
        unset($stmt);
    }

    // Validar la contraseña
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor, ingresa una contraseña.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar la confirmación de la contraseña
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Por favor, confirma tu contraseña.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "La contraseña no coincide.";
        }
    }

    // Validar el correo electrónico
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor, ingresa un correo electrónico.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validar el teléfono
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Por favor, ingresa un número de teléfono.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validar la dirección
    if (empty(trim($_POST["address"]))) {
        $address_err = "Por favor, ingresa una dirección.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Comprobamos si hay errores antes de insertar los datos en la base de datos
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($phone_err) && empty($address_err)) {
        $sql = "INSERT INTO usuario_cliente (Nombre, Contraseña, Puntos_compra_acumulados, Correo, Telefono, Direccion) VALUES (:username, :password, '0', :email, :phone, :address)";

        if ($stmt = $pdo->prepare($sql)) {
            // Asignamos los parámetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);

            // Asignamos los valores
            $param_username = $username;
            $param_password = $password; // Encriptamos la contraseña
            $param_email = $email;
            $param_phone = $phone;
            $param_address = $address;

            // Intentamos ejecutar la sentencia
            if ($stmt->execute()) {
                // Redirigimos al usuario a la página de inicio de sesión
                header("location: login.php");
            } else {
                echo "Oops! Algo salió mal. Por favor, intenta de nuevo más tarde.";
            }
        }

        // Cerramos la sentencia
        unset($stmt);
    }

    // Cerramos la conexión a la base de datos
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="styles.css">
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
<center>
        <div class="wrapper" id="body">
            <h2>Registro de usuario</h2>
            <p>Por favor, llena este formulario para crear una cuenta.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Campos existentes -->
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Nombre de usuario</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>

                <!-- Nuevos campos -->
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                    <label>Número de teléfono</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo $phone; ?>">
                    <span class="help-block"><?php echo $phone_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                    <label>Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                    <span class="help-block"><?php echo $address_err; ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Registrarse">
                    <input type="reset" class="btn btn-default" value="Restablecer">
                </div>

                <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión aquí</a>.</p>
            </form>
        </div>
    </center>

</body>
</html>
