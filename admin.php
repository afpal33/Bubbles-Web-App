<?php
session_start();

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

// Función para verificar si el usuario es un administrador
function esAdmin()
{
    return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
}

// Obtener la lista de usuarios_cliente desde la base de datos
$link = conectarBaseDatos();
$result_cliente = mysqli_query($link, "SELECT ID_usuario, Nombre, Puntos_compra_acumulados FROM usuario_cliente");

// Obtener la lista de usuarios_administrativos desde la base de datos
$result_admin = mysqli_query($link, "SELECT ID_UA, Nombre, CI FROM Usuario_administrativo");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #87CEEB; /* Azul celeste */
            font-family: sans-serif;
            color: black;
        }

        header {
            background-color: #1E90FF; /* Azul claro */
            box-shadow: 3px 3px 3px 5px rgba(0, 0, 0, 0.336);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 90px;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        h1,
        h2,
        h3 {
            color: black;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
        }

        .container {
            margin-top: 150px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
    <title>Administrador</title>
</head>

<body>
    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
        </center>
    </header>

    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- Tabla de usuario_cliente -->
        <h2>Usuarios Cliente</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result_cliente)) : ?>
                        <tr>
                            <td><?= $row['ID_usuario'] ?></td>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['Puntos_compra_acumulados'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de usuario_administrativo -->
        <h2>Usuarios Administrativos</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result_admin)) : ?>
                        <tr>
                            <td><?= $row['ID_UA'] ?></td>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['CI'] ?></td>
                            <td>
                                <a href="#" class="editarAdmin" data-toggle="modal" data-target="#editarAdminModal" data-id="<?= $row['ID_UA'] ?>" data-nombre="<?= $row['Nombre'] ?>" data-ci="<?= $row['CI'] ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario para agregar nuevo usuario_administrativo -->
        <button type="button" class="btn btn-info d-flex flex-row-reverse me-5" data-toggle="modal" data-target="#agregarAdminModal">Agregar Administrativo</button>
        <h2>Promociones</h2>
        <button type="button" class="btn btn-info d-flex flex-row-reverse me-5" data-toggle="modal" data-target="#agregarPromoModal">
    Insertar
</button>

        <div class="container mt-5">
            <div class="row">
                
                
                <?php
                $query = mysqli_query($con, "SELECT * FROM Promo");
            while ($row = mysqli_fetch_assoc($query)) {
                echo
                "<div class='col-lg-4 col-md-6 col-sm-12 mt-4 mt-sm-0'>
                        <div class='card  mt-3' style='width: 18rem;'>
                            <img class='ms-5 mt-3' src='data:image;base64," . base64_encode($row["imagen"]) . "' style='height:200px;width:200px;'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . $row["descripcion"] . "</h5>
                                <p class='card-text'><b>Costo Puntos: </b>" . $row["costo_puntos"] . "</p>
                            " ?>
                <a href="delete.php?id=<?php echo $row["Id_Promo"] ?>" class="btn btn-danger">Eliminar</a>
        </div>
    </div>
    </div>
<?php
}
         
?>
                
            </div>
        </div>
    </div>



    






    <!-- Modal para agregar usuario_administrativo -->
    <div class="modal fade" id="agregarAdminModal" tabindex="-1" role="dialog" aria-labelledby="agregarAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="agregarAdminForm" method="POST" action="admin.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarAdminModalLabel">Agregar Administrador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_admin_agregar">Nombre:</label>
                            <input type="text" id="nombre_admin_agregar" name="nombre_admin_agregar" required>
                        </div>

                        <div class="form-group">
                            <label for="contrasena_admin_agregar">Contraseña:</label>
                            <input type="password" id="contrasena_admin_agregar" name="contrasena_admin_agregar" required>
                        </div>

                        <div class="form-group">
                            <label for="ci_admin_agregar">CI:</label>
                            <input type="text" id="ci_admin_agregar" name="ci_admin_agregar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="agregar_admin" class="btn btn-primary">Agregar Administrativo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario_administrativo -->
    <div class="modal fade" id="editarAdminModal" tabindex="-1" role="dialog" aria-labelledby="editarAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editarAdminForm" method="POST" action="admin.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarAdminModalLabel">Editar Administrador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_admin_editar">Nombre:</label>
                            <input type="text" id="nombre_admin_editar" name="nombre_admin_editar" required>
                        </div>

                        <div class="form-group">
                            <label for="contrasena_admin_editar">Contraseña:</label>
                            <input type="password" id="contrasena_admin_editar" name="contrasena_admin_editar" required>
                        </div>

                        <div class="form-group">
                            <label for="ci_admin_editar">CI:</label>
                            <input type="text" id="ci_admin_editar" name="ci_admin_editar" required>
                        </div>

                        <!-- Añade cualquier otro campo que necesites editar -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="editar_admin" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para agregar promoción -->
    <div class="modal fade" id="agregarPromoModal" tabindex="-1" role="dialog" aria-labelledby="agregarPromoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="insertar.php" method="POST" enctype='multipart/form-data'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarPromoModalLabel">Agregar Promoción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='file' class="form-control mb-3" name='file' required>
                        <input type="text" class="form-control mb-3" name="descripcion" placeholder="Descripción" required>
                        <input type="text" class="form-control mb-3" name="costo_puntos" placeholder="Costo en Puntos" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" value="Upload" class="btn btn-warning">Guardar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Código adicional para mostrar productos de la tabla Promo -->
    <!-- Añadir aquí el código que se encargará de las promociones -->

    <script>
        // Configurar el modal de edición con los datos del usuario_administrativo seleccionado
        $('.editarAdmin').on('click', function () {
            var id_admin = $(this).data('id');
            var nombre_admin = $(this).data('nombre');
            var ci_admin = $(this).data('ci');

            $('#id_admin_editar').val(id_admin);
            $('#nombre_admin_editar').val(nombre_admin);
            $('#ci_admin_editar').val(ci_admin);
        });
    </script>

</body>

</html>
