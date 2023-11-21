<?php
	function Conectarse()
	{//inttroducimos los datos de  host que son "Server", "usuario" y "contraseña" 
		if (!($link=mysqli_connect("localhost","root","")))//aca hay que introducir los datos que especifique arriba!!!
		{
			return 0;
		}
		if (!mysqli_select_db($link,"bubbles_db"))
		{
			return 0;
		}
		return $link;
	}

	//--------------------------

	function alta ($nombre,$producto,$cantidad,$precio_unitario,$total)
	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}
            $total=$precio_unitario*$cantidad;

		// NO poner comillas simples en nombre de tabla, ni de campos, sólo en valores alfanuméricos.
		$consulta = "INSERT INTO carrito (nombre_usuario, producto, cantidad,precio_unitario, total) VALUES ('$nombre', '$producto','$cantidad','$precio_unitario','$total')";

		echo $consulta;

		$resultado=mysqli_query($conexion,$consulta);

			//cerramos la conexión con el motor de BD
			mysqli_close($conexion);
	}

	//--------------------------

	function baja ($producto)
	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de baja. Error al conectar.</h1>";
				exit();
			}

		// NO poner comillas simples en nombre de tabla, ni de campos, sólo en valores alfanuméricos.
		$consulta = "DELETE FROM carrito WHERE producto = $producto";

		echo $consulta . "<BR>";

		$resultado=mysqli_query($conexion,$consulta);

		//echo "Resultado de la operaci&oacute;n: " . $resultado;

			//cerramos la conexión con el motor de BD
			mysqli_close($conexion);

	}

	//--------------------------

	function modificacion ($nombre_usuario, $producto,$cantidad,$precio_unitario,$total)
	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}

		// NO poner comillas simples en nombre de tabla, ni de campos, sólo en valores alfanuméricos.

		/*
		UPDATE `agenda` SET `nombre` = 'pepe3',
						`tel` = '467641_1',
						`direccion` = 'ch 149_1',
						`mail` = 'pepe@host2.com.ar' WHERE `agenda`.`id` =2
		*/
        $total=$precio_unitario*$cantidad;
		$consulta = "UPDATE carrito SET nombre_usuario='$nombre_usuario',producto='$producto',cantidad='$cantidad',precio_unitario='$precio_unitario', total='$total'";
                $consulta = $consulta . "WHERE producto='$producto'";


		echo $consulta;

		$resultado=mysqli_query($conexion,$consulta);

			//cerramos la conexión con el motor de BD
			mysqli_close($conexion);
	}

?>