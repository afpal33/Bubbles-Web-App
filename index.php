<?php
	// Iniciar sesión
	session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>ODONTO UCB</title>
    <style>
        html {
            position: relative;
            min-height: 100%;

        }

        body {
            background-image: url(Images/back1.jpg);
            background-position: 100%;
            font-family: sans-serif;
            margin: 0;
            height: 100%;
            min-height: 100%;
        }

        header {
            background-color: rgba(76, 83, 95, 0.918);
            box-shadow: 3px 3px 3px 5px rgba(0, 0, 0, 0.336);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            
        }

        #button {
            position: absolute;
            top: 32px;
            right: 40px;
        }
        #welcome {
            position: absolute;
            top: 32px;
            right: 25px;
            font-size: 25px;
            color:white;
        }

        #button2 {
            position: absolute;
            top: 105px;
            right: 50px;
        }

        h1 {
            color: white;
        }

        footer {
            font-family: "Raleway", sans-serif;
            background-color: rgb(0, 9, 24);
            color: rgb(146, 146, 146);
            position: static;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .google-maps {
            position: relative;
            padding-bottom: 30%;
            padding-left: 20%;
            height: 0;
            top: 0;
            left: 0;
            overflow: hidden;
        }
        #title, #subtitle{
            font-size:60px;
        }
        .google-maps iframe {
            position: absolute;
            width: 60% !important;
            height: 50% !important;
        }
        #body{
            background-color: rgba(0, 0, 0, 0.651);
            width: 99%;
            border: 15px;
            padding: 30px;
            margin: 10px;
            
        }
    </style>
</head>

<body>

    <header>
        <center>
            <br>
            <img src="images/bubbles.png" style="width:200px;height:200px">
        </center>
        <br>
        <center>
            <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-pills-link-active-bg: var(--bs-white);--bs-nav-pills-link-active-color: var(--bs-primary);--bs-nav-link-color: var(--bs-white);height: 45px; width: 900px">
                <li class="nav-item" role="presentation">
                    <a role="button" href="#home" class="nav-link rounded-5" id="inicio" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a role="button" href="#sillones" class="nav-link rounded-5" id="cat" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Sillones</a>
                </li>
                    <li class="nav-item" role="presentation">
                        <a role="button" href="#pedidos" class="nav-link rounded-5" id="ubi" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Pedidos</a>
                    </li>
                <li class="nav-item" role="presentation">
                    <a role="button" href="#contacto" class="nav-link rounded-5" id="ubi" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Contacto</a>
                </li>
            </ul>
        </center>
        <?php if(isset($_SESSION['username'])): ?>
            <a id="button2" href="logout.php" class="btn btn-primary btn-lg rounded-5 active" role="button" style="background-color: rgb(0, 107, 247);">Cerrar Sesión</a>
            <?php if(isset($_SESSION['username'])): ?>
                <p id="welcome">Bienvenido, <?php echo $_SESSION['username']; ?></p>
            <?php endif; ?>
        <?php else: ?>
        <a id="button" href="login.php" class="btn btn-primary btn-lg rounded-5 active" role="button" style="background-color: rgb(0, 107, 247);">Iniciar Sesión</a>
        <a id="button2" href="register.php" class="btn btn-primary btn-lg rounded-5 active" role="button" style="background-color: rgb(0, 107, 247);">Registrarse</a>
        <?php endif; ?>
        <br>
        <br>
        </div>
    </header>
    <section id="body">
    <div class="content">
            <div id="home" class="tabcontent">
    <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h1 id="title">Odonto UCB</h1>
                <h1 id="subtitle">Calidad y buen gusto. En un solo lugar.</h1>
                <br>
                <br>
                <p style="color:white; font-size: 30px"> Somos una empresa dedicada a la comodidad de nuestros clientes. Los productos que ofrecemos son de muy buena calidad, y hechos con el objetivo de satisfacer a todo público. Inicie sesión o regístrece para poder disfrutar al máximo nuestros servicios.<p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div id="sillones" class="tabcontent">

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
            <div id="sillones" class="tabcontent">
                <h1 style="font-size:60px">Sillones</h1>
                <br>
                <ul style="color:white">
                <div style="display:flex; justify-content:center;">
                    <figure>
                        <img src="images/couch1.jpg" alt="Imagen 1" style="margin-right: 400px;width:400px;height:400px">
                        <figcaption style="color:white;font-size:30px">Sillón Azul, precio: 200$</figcaption>
                        <br>
                        <br>
                    </figure>
                    <figure>
                        <img src="images/couch2.jpg" alt="Imagen 2" style="width:400px;height:400px">
                        <figcaption style="color:white;font-size:30px">Sillón Café, precio: 300$</figcaption>
                        <br>
                        <br>
                    </figure>
                </div>
                </ul>
                <div id="pedidos" class="tabcontent">
                <form method="POST" action="index.php">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <h1 style="font-size:60px">Mis pedidos</h1>
                
                <br>
                <br>
                <?php
                if (isset($_SESSION['username'])) { ?>
                    <?php
                    include("sql.php");
                    $link=Conectarse();
                            if ($link==false)
                            {
                                echo "<H1>Error en apertura de bases de datos.</H1>";
                                exit();
                            }
                        
                        $result=mysqli_query($link,"select * from carrito");
                    ?>
                    
                    
                    <center>
                    <table BORDER=5 CELLSPACING=1 CELLPADDING=1 bordercolor=white>
                        <TR>
                            <TD><b><font color="white">&nbsp;nombre_usuario&nbsp;</font></b></TD>
                            <TD><b><font color="white">&nbsp;producto&nbsp;</font></b></TD>
                            <TD><b><font color="white">&nbsp;cantidad&nbsp;</font></b></TD>
                            <TD><b><font color="white">&nbsp;precio_unitario&nbsp;</font></b></TD>
                            <TD><b><font color="white">&nbsp;total&nbsp;</font></b></TD>
                            </TR>
                            <?php
                                while($row = mysqli_fetch_array($result)) {
                                    echo "<TR>";
                                    echo "<TD>&nbsp;" . $row["nombre_usuario"] . "</TD>";
                                    echo "<TD>&nbsp;" . $row["producto"] . "</TD>";
                                    echo "<TD>&nbsp;" . $row["cantidad"] . "</TD>";
                                    echo "<TD>&nbsp;" . $row["precio_unitario"] . "</TD>";
                                    echo "<TD>&nbsp;" . $row["total"] . "</TD>";
                                    echo "</TR>";
                                }
                                //liberamos memoria que ocupa la consulta...
                                mysqli_free_result($result);
                                
                                //cerramos la conexión con el motor de BD
                                mysqli_close($link);
                            ?>
                    </table>
                    <center>
                        <br>
                        <br>
                        <table BORDER=0 CELLSPACING=1 CELLPADDING=1 bordercolor=white>
                        <TR>
                            <TD><a href="abm.php?accion=alta">Agregar</a></TD>
                            <TD><a href="abm.php?accion=modificacion">Modificar</a></TD>
                            <TD><a href="abm.php?accion=baja">Borrar</a></TD>
                            
                            </TR>
                        <br>
                        
                        <br></table></center>
                <?php } else {?>
                    <h1 style="color:white;font-size:60px">inicie sesión o registrese para visualizar esta sección</h1>
                <?php }
                ?>
                </div>
                <div id="contacto" class="tabcontent">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
		    </div>
            
                <h1 style="font-size:60px">Contacto</h1>
                <div id="ubicacion">
                    <br>
                    <br>
                    <br>
                    <center><h2 style="color:white;">Ubicación: </h2></center>
                    <br>
                    <br>
                        <div class="google-maps">
                            <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.068381990222!2d-68.11417988456829!3d-16.52264504569021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f20ee187a3103%3A0x2f2bb2b7df32a24d!2sUniversidad%20Cat%C3%B3lica%20Boliviana!5e0!3m2!1ses-419!2sbo!4v1677718016911!5m2!1ses-419!2sbo"
                            width="0"
                            height="0"
                            style="border:0;"
                            loading="lazy"
                            ></iframe>
                        </div>
                        <br>
                        <center>
                            <h2 style="color:white">teléfonos: 2798181 - 66522222</h2>
                            <h2 style="color:white">Correo: Ejemplo@gmail.com</h2>
                        </center>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div>
            <br>
            <center>
                <p>
                    <br>
                    <br>
                    Fabrizio Palenque
                    <br>
                    2023
                    <br>
                    andy.palenque@ucb.edu.bo
                    <br>
                    <br>
                </p>
            </center>
        </div>
    </footer>
</body>

</html>