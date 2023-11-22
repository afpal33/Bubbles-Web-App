<?php
session_start();

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
        <h2>Agregar Usuario Administrativo</h2>
        <form method="POST" action="admin.php">
            <div class="form-group">
                <label for="nombre_admin">Nombre:</label>
                <input type="text" name="nombre_admin" required>
            </div>

            <div class="form-group">
                <label for="contrasena_admin">Contraseña:</label>
                <input type="password" name="contrasena_admin" required>
            </div>

            <div class="form-group">
                <label for="ci_admin">CI:</label>
                <input type="text" name="ci_admin" required>
            </div>

            <button type="submit" name="agregar_admin" class="btn btn-primary">Agregar Administrativo</button>
        </form>
    </div>

    <!-- Modal para editar usuario_administrativo -->
    <div class="modal fade" id="editarAdminModal" tabindex="-1" role="dialog" aria-labelledby="editarAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarAdminModalLabel">Editar Administrativo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editarAdminForm" method="POST" action="admin.php">
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

                        <input type="hidden" id="id_admin_editar" name="id_admin_editar">

                        <button type="submit" name="editar_admin" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
