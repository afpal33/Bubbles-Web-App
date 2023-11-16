<html>
	<head>
		<!-- de acuerdo al contenido de la variable "accion", escribimos el título -->
		<?php
			if ($_GET["accion"] == "alta")
				echo "<title>" . "Alta de registro" . "</title>";

			if ($_GET["accion"] == "baja")
				echo "<title>" . "Baja en la agenda" . "</title>";

			if ($_GET["accion"] == "modificacion")
				echo "<title>" . "Modificaci&oacute;n en agenda" . "</title>";
		?>
	</head>
    
	<body bgcolor="black">
            <div id="sillones" class="tabcontent">
                <h1 style="font-size:60px">Sillones</h1>
                <br>
                <ul style="color:white">
                <div style="display:flex; justify-content:center;">
                    <figure>
                        <img src="images/couch1.jpg" alt="Imagen 1" style="margin-right: 400px;width:400px;height:400px">
                        <figcaption style="color:white;font-size:30px">Producto 1, precio: 200$</figcaption>
                        <br>
                        <br>
                    </figure>
                    <figure>
                        <img src="images/couch2.jpg" alt="Imagen 2" style="width:400px;height:400px">
                        <figcaption style="color:white;font-size:30px">Producto 2, precio: 300$</figcaption>
                        <br>
                        <br>
                    </figure>
                </div>
		<?php
			// Acá mostramos la pantalla de carga de ALTAS.
			if ($_GET["accion"] == "alta")
			{
            echo "<center>";				
				echo "<h1><font color=\"blue\">Agregar Registro</font></h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "Nombre: " . "<INPUT TYPE=\"TEXT\" NAME=\"nomb_usr\">" . "<BR>";
					echo "<BR>";
					echo "Pedido: " . "<INPUT TYPE=\"TEXT\" NAME=\"ped\">" . "<BR>";
					echo "<BR>";
					echo "Cantidad:    " .   "<INPUT TYPE=\"NUMBER\" NAME=\"cant\">" .   "<BR>";
					echo "<BR>";
					echo "Precio_unitario: " . "<INPUT TYPE=\"NUMBER\" NAME=\"pu\">" . "<BR>";
					echo "<BR>";
					echo "<INPUT TYPE=\"submit\" NAME=\"OK\">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_alta\">";

				echo "</FORM>";

				echo "</center>";

				exit();
			}
		?>



		<?php
			// Acá, en base a los datos recibidos (nombre, telefono, direccion, etc), hacemos el alta.
			if ($_GET["accion"] == "realizar_alta")
			{
				include("sql.php");

				$nombre_usuario = $_GET["nomb_usr"];
				$pedido = $_GET["ped"];
				$cantidad = $_GET["cant"];
				$precio_unitario = $_GET["pu"];
                $total = $precio_unitario*$cantidad;
				alta ($nombre_usuario,$pedido,$cantidad,$precio_unitario,$total);

				
			}
		?>

		

		<?php
			//Acá solicitamos el ID para poder modificar el registro.
			if ($_GET["accion"] == "modificacion")
			{
            echo"<center>";				
				echo "<h1><font color=\"blue\">Modificar un registro<font></h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "ID producto: " . "<INPUT TYPE=\"TEXT\" NAME=\"ped\">" . "<BR>";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"datos_modificacion\">";
				echo "</FORM>";
				echo "</center>";

				

				exit();
			}
		?>
		


		<?php
			// Acá, en base al ID recibido, pedimos los datos para MODIFICAR.
			if ($_GET["accion"] == "datos_modificacion")
			{
				include("sql.php");

				
				$conexion = Conectarse();

					if (!$conexion)
					{
						echo "<h1>Error al intentar conectar a BD</h1>";
						
						exit();
					}

				$id_producto = $_GET["ped"];
				$consulta = "SELECT * FROM carrito WHERE producto = $id_producto";

				echo $consulta . "<br>";

				$resultado = mysqli_query($conexion,$consulta);

				$fila = mysqli_fetch_array($resultado);

				if (!$fila)
				{
					echo "<h1>Registro inexistente</h1>";
				
					exit();
				}

				//cargo los datos del registro en variables para que sea más cómodo trabajar.

                $nombre = $fila["nombre_usuario"];
                $pedido = $fila["pedido"];
                $cantidad = $fila["cantidad"];
                $precio_unitario = $fila["precio_unitario"];
                $total = $precio_unitario*$cantidad;

				   //liberamos memoria que ocupa la consulta...
				   mysqli_free_result($resultado);

				   //cerramos la conexión con el motor de BD
				   mysqli_close($conexion);

				/*
				ahora que teóricamente tengo los datos del registro que quiero modificar, muestro
				el formulario de carga.
				*/
            echo "<center>";				
				echo "<h1><font color=\"blue\">Modificar un registro</font></h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
				echo "nombre: " . "<INPUT TYPE=\"TEXT\" NAME=\"nomb_usr\" VALUE=\"$nombre\">" . "<BR>";
				echo "pedido: " . "<INPUT TYPE=\"TEXT\" NAME=\"id_prod\" VALUE=\"$id_producto\">" . "<BR>";
				echo "cantidad: " . "<INPUT TYPE=\"NUMBER\" NAME=\"cant\" VALUE=\"$cantidad\">" . "<BR>";
			   echo "precio_unitario: " . "<INPUT TYPE=\"NUMBER\" NAME=\"pu\" VALUE=\"$precio_unitario\">" . "<BR>";

                                echo "<BR>";
				echo "<INPUT TYPE=\"submit\" NAME=\"submit\" value=\"Enviar\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_modificacion\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"id\" VALUE=\"$id_producto\">";
				echo "</FORM>";
				echo "</center>";

				
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la modificación.
			if ($_GET["accion"] == "realizar_modificacion")
			{
				include("sql.php");

                $nombre_usuario = $_GET["nomb_usr"];
				$id_producto = $_GET["id+_prod"];
                $cantidad = $_GET["cant"];
                $precio_unitario = $GET["cant"];
                $total=$precio_unitario*$cantidad;
				modificacion($nombre_usuario, $id_producto,$cantidad,$precio_unitario,$total);
			
			}

		?>
		

		<?php
			// Acá mostramos la pantalla de carga de BAJAS.
			if ($_GET["accion"] == "baja")
			{
            echo"<center>";				
				echo "<h1><font color=\"blue\">Eliminar Registro</font></h1>";
				echo "<br>";
				echo "<FORM ACTION=\"abm.php\" METHOD=\"GET\">";
					echo "ID del producto: " . "<INPUT TYPE=\"TEXT\" NAME=\"ped\">" . "<BR>";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_baja\">";
				echo "</FORM>";
				echo"</center>";
				
				
				
				exit();
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la baja.
			if ($_GET["accion"] == "realizar_baja")
			{
				include("sql.php");
				
				$id_producto = $_GET["ped"];
				
				baja($id_producto);
				
				
			}
		?>

		<form action="index.php" method="POST">
<center><input type=submit value=Volver><center>
</form>

	</body>
</html>