<?php
session_start();



$con = conectarBaseDatos();

if (isset($_GET['id']) && isset($_GET['costo_puntos'])) {
    $id_promo = $_GET['id'];
    $costo_puntos = $_GET['costo_puntos'];

    // Obtener el ID del usuario logueado
    $id_usuario = $_SESSION['ID_usuario'];

    // Obtener la cantidad actual de puntos del usuario
    $query_puntos_usuario = mysqli_query($con, "SELECT Puntos_compra_acumulados FROM usuario_cliente WHERE ID_usuario = '$id_usuario'");
    
    if ($query_puntos_usuario) {
        $row_puntos_usuario = mysqli_fetch_assoc($query_puntos_usuario);

        // Verificar si el usuario tiene suficientes puntos para el canje
        if ($row_puntos_usuario && $row_puntos_usuario['Puntos_compra_acumulados'] >= $costo_puntos) {
            // Realizar el canje restando los puntos
            $nuevos_puntos = $row_puntos_usuario['Puntos_compra_acumulados'] - $costo_puntos;
            $query_canjear = "UPDATE usuario_cliente SET Puntos_compra_acumulados = '$nuevos_puntos' WHERE ID_usuario = '$id_usuario'";
            
            if (mysqli_query($con, $query_canjear)) {
                echo '<script>';
                echo 'alert("Canje exitoso. Puntos restantes: ' . $nuevos_puntos . '");';
                echo 'window.location.href = "index.php";'; // Puedes redirigir a donde desees después del canje exitoso
                echo '</script>';
                

            } else {
                echo "Error al realizar el canje: " . mysqli_error($con);
            }
        } else {
            echo "No tienes suficientes puntos para este canje.";
        }
    } else {
        echo "Error al obtener los puntos del usuario: " . mysqli_error($con);
    }
} else {
    echo "Parámetros incorrectos para el canje.";
}

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
?>
