<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "racers";
$username = "root";
$password = "";

// Intentamos conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Habilitamos los errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Iniciamos la sesión
session_start();

// Si el usuario ya ha iniciado sesión, redirigimos a la página principal
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Definimos las variables y las inicializamos con valores vacíos
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Procesamos los datos del formulario cuando se envía el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validar el nombre de usuario
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor, ingresa un nombre de usuario.";
    } else{
        // Preparamos una sentencia SELECT para comprobar si el nombre de usuario ya está en uso
        $sql = "SELECT id FROM usuarios WHERE usuario = :username";

        if($stmt = $pdo->prepare($sql)){
            // Asignamos los parámetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Asignamos los valores
            $param_username = trim($_POST["username"]);

            // Intentamos ejecutar la sentencia
            if($stmt->execute()){
                // Si el nombre de usuario no está en uso, lo asignamos a la variable $username
                if($stmt->rowCount() == 1){
                    $username_err = "Este nombre de usuario ya está en uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Algo salió mal. Por favor, intenta de nuevo más tarde.";
            }
        }

        // Cerramos la sentencia
        unset($stmt);
    }

    // Validar la contraseña
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingresa una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validar la confirmación de la contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirma tu contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "La contraseña no coincide.";
        }
    }

    // Comprobamos si hay errores antes de insertar los datos en la base de datos
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){   
        $sql = "INSERT INTO usuarios (usuario, password) VALUES (:username, :password)";

        if($stmt = $pdo->prepare($sql)){
            // Asignamos los parámetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            // Asignamos los valores
            $param_username = $username;
            $param_password = $password; // Encriptamos la contraseña

            // Intentamos ejecutar la sentencia
            if($stmt->execute()){
                // Redirigimos al usuario a la página de inicio de sesión
                header("location: login.php");
            } else{
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
        html {
            position: relative;
            min-height: 100%;
            color:white;

        }

        body {
            background-image: url(Images/back1.jpg);
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
        #body{
            background-color: rgba(0, 0, 0, 0.822);
            width: 95%;
            border: 15px;
            padding: 30px;
            margin: 10px;
            
        } 
    </style>
</head>
<body><center>
    <div class="wrapper" id="body">
        <h2>Registro de usuario</h2>
        <p>Por favor, llena este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <br>
                <label>Nombre de usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
                <br>
                <br>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
                <br>
                <br>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
                <br>
                <br>
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
