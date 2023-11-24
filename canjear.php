<?php
session_start();
require 'fpdf/fpdf.php';


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
            
            // Obtener la descripción y los puntos de la promoción
            $query_promo = mysqli_query($con, "SELECT descripcion FROM promo WHERE Id_Promo = '$id_promo'");
            $row_promo = mysqli_fetch_assoc($query_promo);
            $descripcion_promo = $row_promo['descripcion'];
            $puntos_promo = $_GET['costo_puntos'];

            



         // Crear el objeto FPDF
         $pdf = new FPDF();

         // Agregar una página
         $pdf->AddPage();

         // Agregar el logo
         $logoPath = 'Images/bubbles.png';
         $pdf->Image($logoPath, 10, 10, 33);

         // Establecer la fuente y el tamaño de la letra para la descripción de la promoción
         $pdf->SetFont('Arial', '', 12);

         $pdf->Ln(20);

         $pdf->Cell(0, 15, 'CUPON DE DESCUENTO ',0, 1, 'C');


         // Escribir la descripción de la promoción
         $pdf->Cell(0, 10, 'PROMOCION: '.utf8_decode($descripcion_promo),0, 1, 'L');

          // Escribir la descripción de la promoción
          $pdf->Cell(0, 10, 'COSTO: '.utf8_decode($puntos_promo),0, 1, 'L');

         // Generar un código aleatorio para el canje
         $codigoCanje = generarCodigoAleatorio(8); // Ajusta la longitud según tus necesidades

         // Mostrar el nombre del usuario, el código de canje y la fecha actual
         $pdf->Ln(10);
         $pdf->Cell(0, 10, 'Usuario: ' . $_SESSION['username'], 0, 1, 'L');
         $pdf->Cell(0, 10, 'Codigo de Canje: ' . $codigoCanje, 0, 1, 'L');
         $pdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d'), 0, 1, 'L');

         // Generar el archivo PDF
         $pdfFileName = 'canje.pdf';
         $pdf->Output($pdfFileName, 'F');
            
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
    $password = "marco1211";
    $dbname = "bubbles_db";

    $link = mysqli_connect($servername, $username, $password, $dbname);

    if (!$link) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $link;
}

// Función para generar un código aleatorio
function generarCodigoAleatorio($longitud)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}
?>
