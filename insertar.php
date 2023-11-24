<?php
$con = conectarBaseDatos();

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

if (isset($_FILES["file"])) {
    $fileName = basename($_FILES["file"]["name"]);
    $fileType = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    $fileType = strtolower($fileType);
    $uploadFile = $fileName . rand(1000, 10000) . "." . $fileType;

    if ($fileType != 'jpg' && $fileType != 'jpeg' && $fileType != 'png' && $fileType != 'gif') {
        echo "Upload Failed. Invalid File Extension!";
    } else {
        $imgData = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        $descripcion = $_POST['descripcion'];
        $costo_puntos = $_POST['costo_puntos'];

        $sql = "INSERT INTO Promo (imagen, descripcion, costo_puntos) VALUES('{$imgData}', '{$descripcion}', '{$costo_puntos}')";
        $query = mysqli_query($con, $sql);

        if ($query) {
            echo "File Uploaded Successfully!";
            header("Location: admin.php");
        } else {
            echo "File Upload Failed!";
        }
    }
}
?>

