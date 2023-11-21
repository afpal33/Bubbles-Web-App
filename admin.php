<?php
    session_start();

    // Verifica que el usuario tenga acceso de administrador, de lo contrario, redirige
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header("Location: admin.php"); // Ajusta la redirección según tus necesidades
        exit;
    }

    // Conéctate a la base de datos (ajusta los detalles de conexión)
    $servername = "tu_servidor";
    $username = "tu_usuario";
    $password = "tu_contraseña";
    $database = "tu_base_de_datos";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }

    // Función para mostrar usuarios en la tabla
    function mostrarUsuarios($conn) {
        $sql = "SELECT id, nombre, puntos_cliente_regular FROM usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["puntos_cliente_regular"] . "</td>";
                echo '<td><a href="admin.php?accion=editar&id=' . $row["id"] . '">Editar</a> | <a href="admin.php?accion=eliminar&id=' . $row["id"] . '">Eliminar</a></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
        }
    }

    // Función para realizar operaciones de ABM
    function gestionarUsuarios($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Procesa el formulario según la acción
            $accion = $_POST["accion"];

            if ($accion == "alta") {
                // Lógica para agregar un nuevo usuario
                // Recupera los datos del formulario (ajusta los nombres de los campos según tu estructura)
                $nombre = $_POST["nombre"];
                $puntosClienteRegular = $_POST["puntos_cliente_regular"];

                $sql = "INSERT INTO usuarios (nombre, puntos_cliente_regular) VALUES ('$nombre', '$puntosClienteRegular')";
                if ($conn->query($sql) === TRUE) {
                    echo "Usuario agregado exitosamente.";
                } else {
                    echo "Error al agregar usuario: " . $conn->error;
                }
            } elseif ($accion == "editar") {
                // Lógica para editar un usuario existente
                // Recupera los datos del formulario y el ID del usuario a editar
                $idUsuario = $_POST["id"];
                $nombre = $_POST["nombre"];
                $puntosClienteRegular = $_POST["puntos_cliente_regular"];

                $sql = "UPDATE usuarios SET nombre='$nombre', puntos_cliente_regular='$puntosClienteRegular' WHERE id=$idUsuario";
                if ($conn->query($sql) === TRUE) {
                    echo "Usuario editado exitosamente.";
                } else {
                    echo "Error al editar usuario: " . $conn->error;
                }
            } elseif ($accion == "eliminar") {
                // Lógica para eliminar un usuario
                // Recupera el ID del usuario a eliminar
                $idUsuario = $_POST["id"];

                $sql = "DELETE FROM usuarios WHERE id=$idUsuario";
                if ($conn->query($sql) === TRUE) {
                    echo "Usuario eliminado exitosamente.";
                } else {
                    echo "Error al eliminar usuario: " . $conn->error;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<!-- ... Resto del código HTML ... -->

<body>

    <!-- ... Resto del contenido HTML ... -->

    <!-- Formulario para gestionar usuarios -->
    <div>
        <h2>ABM de Usuarios</h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="accion" value="alta"> <!-- Puedes cambiar esta acción según tus necesidades -->

            <!-- Añade campos para ingresar información del usuario -->
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="puntos_cliente_regular">Puntos Cliente Regular:</label>
            <input type="text" name="puntos_cliente_regular" required>

            <button type="submit">Agregar Usuario</button>
        </form>

        <!-- Tabla de usuarios -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Puntos Cliente Regular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Muestra la tabla de usuarios
                    mostrarUsuarios($conn);
                ?>
            </tbody>
        </table>
    </div>

    <!-- ... Resto del contenido HTML ... -->

</body>

</html>

<?php
    // Gestionar usuarios después de enviar el formulario
    gestionarUsuarios($conn);

    // Cierra la conexión a la base de datos al finalizar
    $conn->close();
?>
