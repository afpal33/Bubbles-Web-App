<?php

$con = conectarBaseDatos();

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

    $Id_Promo=$_GET['id'];

    $sql="DELETE FROM promo WHERE Id_Promo='$Id_Promo'";
    $query=mysqli_query($con,$sql);

    if($query){
        Header("Location: admin.php");
        echo "<script>alert('Promoción eliminada')</script>";
    }else {
        echo "Error al eliminar el registro";
    }
?>
