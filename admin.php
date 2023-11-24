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
                <!-- Agrega este botón de cierre de sesión -->
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                <?php endif; ?>
            </center>
        </header>


    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- ... (código anterior) -->

        <!-- Tabla de usuario_cliente -->
        <h2>Usuarios Cliente</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Modificar la consulta para obtener también correo y teléfono
                    $result_cliente = mysqli_query($link, "SELECT ID_usuario, Nombre, Correo, Telefono, Puntos_compra_acumulados FROM usuario_cliente");
                    while ($row = mysqli_fetch_array($result_cliente)) :
                    ?>
                        <tr>
                            <td><?= $row['ID_usuario'] ?></td>
                            <td><?= $row['Nombre'] ?></td>
                            <td><?= $row['Correo'] ?></td>
                            <td><?= $row['Telefono'] ?></td>
                            <td><?= $row['Puntos_compra_acumulados'] ?></td>
                            <!-- Agrega un botón para agregar puntos directamente -->
                            <td>
                                <form method="POST" action="admin.php">
                                    <input type="hidden" name="id_usuario_agregar_puntos" value="<?= $row['ID_usuario'] ?>">
                                    <button type="submit" name="agregar_puntos" class="btn btn-info">Agregar 100 Puntos</button>
                                    <button type="button" class="btn btn-primary editarCliente" data-toggle="modal" data-target="#editarClienteModal" data-id="<?= $row['ID_usuario'] ?>" data-nombre="<?= $row['Nombre'] ?>" data-correo="<?= $row['Correo'] ?>" data-telefono="<?= $row['Telefono'] ?>" data-puntos="<?= $row['Puntos_compra_acumulados'] ?>">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarCliente" data-toggle="modal" data-target="#eliminarClienteModal" data-id="<?= $row['ID_usuario'] ?>">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

<!-- ... (código posterior) -->


        

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
                                    <button type="button" class="btn btn-primary editarAdmin" data-toggle="modal" data-target="#editarAdminModal" data-id="<?= $row['ID_UA'] ?>" data-nombre="<?= $row['Nombre'] ?>" data-ci="<?= $row['CI'] ?>">Editar</button>
                                    <button type="button" class="btn btn-danger eliminarAdmin" data-toggle="modal" data-target="#eliminarAdminModal" data-id="<?= $row['ID_UA'] ?>">Eliminar</button>
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

</div>

<!-- Formulario para agregar nuevo usuario_administrativo -->
<div class="modal fade" id="agregarAdminModal" tabindex="-1" role="dialog" aria-labelledby="agregarAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="agregarAdminForm" method="POST" action="admin.php">
                <!-- Agregué un campo oculto para identificar si la acción es agregar o editar -->
                <input type="hidden" name="accion_admin" id="accion_admin" value="agregar">

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

<!-- Formulario para editar usuario_administrativo -->
<div class="modal fade" id="editarAdminModal" tabindex="-1" role="dialog" aria-labelledby="editarAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editarAdminForm" method="POST" action="admin.php">
                <!-- Agregué un campo oculto para identificar si la acción es agregar o editar -->
                <input type="hidden" name="accion_admin" id="accion_admin" value="editar">
                <input type="hidden" id="id_admin_editar" name="id_admin_editar">

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
<!-- Modal para eliminar usuario_administrativo -->
<div class="modal fade" id="eliminarAdminModal" tabindex="-1" role="dialog" aria-labelledby="eliminarAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="eliminarAdminForm" method="POST" action="admin.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarAdminModalLabel">Eliminar Administrador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                        <p>Para confirmar la eliminación, ingrese la contraseña del usuario administrativo:</p>
                            <label for="contrasena_admin_eliminar">Contraseña:</label>
                            <input type="password" id="contrasena_admin_eliminar" name="contrasena_admin_eliminar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id_admin_eliminar" name="id_admin_eliminar">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="eliminar_admin" class="btn btn-danger">Eliminar Administrativo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal para editar usuario_cliente -->
<div class="modal fade" id="editarClienteModal" tabindex="-1" role="dialog" aria-labelledby="editarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editarClienteForm" method="POST" action="admin.php">
                <!-- Agregué un campo oculto para identificar si la acción es agregar o editar -->
                <input type="hidden" name="accion_cliente" id="accion_cliente" value="editar">
                <input type="hidden" id="id_cliente_editar" name="id_cliente_editar">

                <div class="modal-header">
                    <h5 class="modal-title" id="editarClienteModalLabel">Editar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre_cliente_editar">Nombre:</label>
                        <input type="text" id="nombre_cliente_editar" name="nombre_cliente_editar" required>
                    </div>

                    <div class="form-group">
                        <label for="correo_cliente_editar">Correo:</label>
                        <input type="email" id="correo_cliente_editar" name="correo_cliente_editar" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono_cliente_editar">Teléfono:</label>
                        <input type="text" id="telefono_cliente_editar" name="telefono_cliente_editar" required>
                    </div>

                    <div class="form-group">
                        <label for="puntos_cliente_editar">Puntos:</label>
                        <input type="text" id="puntos_cliente_editar" name="puntos_cliente_editar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="editar_cliente" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para eliminar usuario_cliente -->
<div class="modal fade" id="eliminarClienteModal" tabindex="-1" role="dialog" aria-labelledby="eliminarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="eliminarClienteForm" method="POST" action="admin.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarClienteModalLabel">Eliminar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este cliente?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_cliente_eliminar" name="id_cliente_eliminar">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="eliminar_cliente" class="btn btn-danger">Eliminar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ... (código posterior) -->
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

    // Configurar el modal de eliminación con los datos del usuario_administrativo seleccionado
    $('.eliminarAdmin').on('click', function () {
            var id_admin = $(this).data('id');
            var nombre_admin = $(this).data('nombre');

            $('#id_admin_eliminar').val(id_admin);
            // Puedes agregar el nombre a algún elemento del modal si lo necesitas
            // $('#nombre_admin_eliminar').text(nombre_admin);
        });

</script>
<script>
    $('.editarCliente').on('click', function () {
        var id_cliente = $(this).data('id');
        var nombre_cliente = $(this).data('nombre');
        var correo_cliente = $(this).data('correo');
        var telefono_cliente = $(this).data('telefono');
        var puntos_cliente = $(this).data('puntos');

        $('#id_cliente_editar').val(id_cliente);
        $('#nombre_cliente_editar').val(nombre_cliente);
        $('#correo_cliente_editar').val(correo_cliente);
        $('#telefono_cliente_editar').val(telefono_cliente);
        $('#puntos_cliente_editar').val(puntos_cliente);
    });

    // Configurar el modal de eliminación con los datos del usuario_cliente seleccionado
    $('.eliminarCliente').on('click', function () {
        var id_cliente = $(this).data('id');

        $('#id_cliente_eliminar').val(id_cliente);
    });

</script>


<?php
// ... (código anterior)

// Procesar el formulario para agregar un nuevo usuario administrativo
if (isset($_POST['agregar_admin'])) {
    $nombre_admin_agregar = $_POST['nombre_admin_agregar'];
    $contrasena_admin_agregar = $_POST['contrasena_admin_agregar'];
    $ci_admin_agregar = $_POST['ci_admin_agregar'];

    $query_agregar_admin = "INSERT INTO Usuario_administrativo (Nombre, Contraseña, CI) VALUES ('$nombre_admin_agregar', '$contrasena_admin_agregar', '$ci_admin_agregar')";

    if (mysqli_query($link, $query_agregar_admin)) {
        
        echo '<script>window.location.href="admin.php";</script>';
    } else {
        echo "Error al agregar usuario administrativo: " . mysqli_error($link);
    }
}

// Procesar el formulario para editar un usuario administrativo
if (isset($_POST['editar_admin'])) {
    $id_admin_editar = $_POST['id_admin_editar'];
    $nombre_admin_editar = $_POST['nombre_admin_editar'];
    $contrasena_admin_editar = $_POST['contrasena_admin_editar'];
    $ci_admin_editar = $_POST['ci_admin_editar'];

    $query_editar_admin = "UPDATE Usuario_administrativo SET Nombre='$nombre_admin_editar', Contraseña='$contrasena_admin_editar', CI='$ci_admin_editar' WHERE ID_UA='$id_admin_editar'";

    if (mysqli_query($link, $query_editar_admin)) {
        
        echo '<script>window.location.href="admin.php";</script>';
    } else {
        echo "Error al editar usuario administrativo: " . mysqli_error($link);
    }
}


// Procesar el formulario para eliminar un usuario administrativo
if (isset($_POST['eliminar_admin'])) {
    $id_admin_eliminar = $_POST['id_admin_eliminar'];
    $contrasena_admin_eliminar = $_POST['contrasena_admin_eliminar'];

    // Consulta preparada para mejorar la seguridad
    $query_verificar_contrasena = "SELECT Contraseña FROM Usuario_administrativo WHERE ID_UA=? AND Contraseña=?";
    $stmt = mysqli_prepare($link, $query_verificar_contrasena);
    mysqli_stmt_bind_param($stmt, "ss", $id_admin_eliminar, $contrasena_admin_eliminar);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Contraseña correcta, proceder con la eliminación
        $query_eliminar_admin = "DELETE FROM Usuario_administrativo WHERE ID_UA='$id_admin_eliminar'";

        if (mysqli_query($link, $query_eliminar_admin)) {
            echo '<script>window.location.href="admin.php";</script>';
        } else {
            echo "Error al eliminar usuario administrativo: " . mysqli_error($link);
        }
    } else {
        echo "Contraseña incorrecta. No se pudo eliminar el usuario administrativo.";
    }

    mysqli_stmt_close($stmt);
}

// Procesar el formulario para agregar puntos
if (isset($_POST['agregar_puntos'])) {
    $id_usuario_agregar_puntos = $_POST['id_usuario_agregar_puntos'];

    // Actualizar la cantidad de puntos del usuario agregando 100 puntos
    $query_agregar_puntos = "UPDATE usuario_cliente SET Puntos_compra_acumulados = Puntos_compra_acumulados + 100 WHERE ID_usuario = '$id_usuario_agregar_puntos'";

    if (mysqli_query($link, $query_agregar_puntos)) {
        echo '<script>window.location.href="admin.php";</script>';
    } else {
        echo "Error al agregar puntos: " . mysqli_error($link);
    }
}





// Procesar el formulario para editar un usuario cliente
if (isset($_POST['editar_cliente'])) {
    $id_cliente_editar = $_POST['id_cliente_editar'];
    $nombre_cliente_editar = $_POST['nombre_cliente_editar'];
    $correo_cliente_editar = $_POST['correo_cliente_editar'];
    $telefono_cliente_editar = $_POST['telefono_cliente_editar'];
    $puntos_cliente_editar = $_POST['puntos_cliente_editar'];

    $query = "UPDATE usuario_cliente SET Nombre='$nombre_cliente_editar', Correo='$correo_cliente_editar', Telefono='$telefono_cliente_editar', Puntos_compra_acumulados='$puntos_cliente_editar' WHERE ID_usuario=$id_cliente_editar";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        echo '<script>window.location.href="admin.php";</script>';
    } else {
        echo '<script>alert("Error al actualizar el usuario cliente.");</script>';
    }
}

// Procesar el formulario para eliminar un usuario cliente
if (isset($_POST['eliminar_cliente'])) {
    $id_cliente_eliminar = $_POST['id_cliente_eliminar'];

    $query = "DELETE FROM usuario_cliente WHERE ID_usuario=$id_cliente_eliminar";
    $resultado = mysqli_query($link, $query);

    if ($resultado) {
        echo '<script>window.location.href="admin.php";</script>';
    } else {
        echo '<script>alert("Error al eliminar el usuario cliente.");</script>';
    }
}

?>

</body>

</html>

