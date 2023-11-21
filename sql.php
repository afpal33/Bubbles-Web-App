
<?php
session_start(); // Inicia la sesión al principio del archivo

// Función para conectar a la base de datos
function Conectarse()
{
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "bubbles_db";

    // Crear conexión
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>

