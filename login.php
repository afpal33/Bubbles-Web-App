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
            color:white;

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
        #body{
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

		// Verificar si el formulario ha sido enviado
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Obtener los valores del formulario
			$username = $_POST["username"];
			$password = $_POST["password"];
			// Consultar la base de datos para verificar las credenciales del usuario
			$sql = "SELECT * FROM usuario_cliente WHERE Nombre = '$username' AND Contrasena= '$password'";
			$result = mysqli_query($conn, $sql);

			// Verificar si se encontró un usuario con esas credenciales
			if (mysqli_num_rows($result) == 1) {
				// Iniciar sesión
				session_start();
				$_SESSION["username"] = $username;

				// Redirigir al usuario a la página de inicio
				header("Location: index.php");
				exit();
			} else {
				// Mostrar un mensaje de error si no se encontró un usuario con esas credenciales
				echo "<center><p>Usuario o contraseña incorrecto. Intente de nuevo.</p></center>";
			}
		}

		// Cerrar la conexión a la base de datos
		mysqli_close($conn);
	?>
    <div>
        
</body>
</html>