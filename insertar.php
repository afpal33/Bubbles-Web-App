<?php
include("database.php");

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
            header("Location: /admin.php");
            exit();
        } else {
            echo "Error en la inserción: " . mysqli_error($con);
        }
    }
}
?>
