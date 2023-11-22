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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>BUBBLES</title>
    <style>
         html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

body {
  background-color: #87CEEB; /* Azul celeste */
  font-family: sans-serif;
  color: black; /* Texto en negro */
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

#logo {
  max-width: 100%;
  height: auto;
  width: 150px;
  height: 50px;
}

#pillNav2 {
  height: 45px;
  width: 900px;
  margin: 0 auto;
}

#button {
  margin-right: 20px;
}

#welcome {
  font-size: 25px;
  color: black;
}

#button2 {
  margin-left: 20px;
}

h1 {
    color: black; /* Texto en negro */
    font-size: 36px; /* Tamaño de fuente */
    font-weight: bold; /* Fuente en negrita */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra de texto */
    text-align: center; /* Texto centrado */
    margin-bottom: 10px; /* Margen inferior */
  }

footer {
  font-family: "Raleway", sans-serif;
  background-color: black;
  color: #1E90FF; /* Azul claro */
  position: static;
  left: 0;
  bottom: 0;
  width: 100%;
  padding: 20px;
  text-align: center;
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

        #title,
        #subtitle {
            font-size: 60px;
        }

        .google-maps iframe {
            position: absolute;
            width: 60% !important;
            height: 50% !important;
        }

        #body {
            background-color: white;
            width: 95%; /* Reduje el ancho para dejar espacio alrededor */
            border: 10px solid #ddd; /* Cambié el grosor del borde y el color */
            border-radius: 15px; /* Añadí un radio a las esquinas */
            padding: 20px; /* Ajusté el relleno */
            margin: 20px auto; /* Centré el elemento en la página */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Añadí una suave sombra */
        }


        
    </style>
</head>

<body>

    <header>
        <center>
            <br>
            <img src="Images/bubbles.png" style="width:200px;height:70px">
        </center>
        <br>
        <center>
            <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-pills-link-active-bg: var(--bs-black);--bs-nav-pills-link-active-color: var(--bs-primary);--bs-nav-link-color: var(--bs-black);height: 45px; width: 900px">
                <li class="nav-item" role="presentation">
                    <a role="button" href="#home" class="nav-link rounded-5" id="inicio" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a role="button" href="#servicios" class="nav-link rounded-5" id="cat" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Servicios</a>
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
        <a id="button2" href="abm.php" class="btn btn-primary btn-lg rounded-5 active" role="button" style="background-color: rgb(0, 107, 247);">Registrarse</a>
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



    <div class="container">
        <h1>ANUNCIOS:</h1>
        <br>
        <div id="myCarousel" class="carousel slide" data-ride="carousel"style="max-width: 600px; margin: 0 auto;">
            <!-- Indicadores -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Imágenes -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="Images/home1.jpg" alt="Imagen 1" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="Images/home2.jpg" alt="Imagen 2" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="Images/home3.jpg" alt="Imagen 3" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="Images/home4.jpg" alt="Imagen 4" class="d-block w-100">
                </div>
            </div>

            <!-- Controles -->
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>

        <!-- Indicador de posición -->
        <p id="position-indicator"></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inicializa el carrusel
            $('#myCarousel').carousel();

            // Actualiza el indicador de posición al cambiar de diapositiva

        });
    </script>

    <script>
        // Agrega la funcionalidad de navegación automática
        const carousel = document.querySelector('#imagenCarousel');
        const interval = 4000; // Cambia el intervalo según tus preferencias (en milisegundos)
        function activateCarousel() {
            setInterval(() => {
                const currentSlide = document.querySelector('.carousel-item.active');
                const nextSlide = currentSlide.nextElementSibling || carousel.querySelector('.carousel-item:first-child');
                currentSlide.classList.remove('active');
                nextSlide.classList.add('active');
            }, interval);
        }

        // Activa la funcionalidad cuando la ventana se haya cargado completamente
        window.onload = activateCarousel;
    </script> 
    <!--Agrega los enlaces a los scripts de Bootstrap y jQuery antes de cerrar el cuerpo del documento-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
    <br>
    <h1 id="title">Bienvenido a Bubbles</h1>
    <h1 id="subtitle">Calidad y buen gusto. En un solo lugar.</h1>
    <br>
    <br>
    <p style="color:black; font-size: 30px">Somos una empresa dedicada a la comodidad de nuestros clientes. Los productos que ofrecemos son de muy buena calidad, y hechos con el objetivo de satisfacer a todo público. Inicie sesión o regístrese para poder disfrutar al máximo nuestros servicios.</p>
    <br>
    <br>
    <div style="display: flex; justify-content: space-around; align-items: center;">
    <div style="text-align: center;">
        <img src="Images/vision.jpg" alt="Imagen 1" style="width: 300px; height: 200px;">
        <p style="color: black; font-size: 20px;">Nuestra visión es que Bubbles sea reconocida como la mejor opción en servicios de lavandería en la zona, ofreciendo una experiencia de alta calidad y satisfacción al cliente.</p>
    </div>
    <div style="text-align: center;">
        <img src="Images/mision.jpg" alt="Imagen 2" style="width: 200px; height: 200px;">
        <p style="color: black; font-size: 20px;">Nuestra misión es proporcionar servicios de lavandería confiables y eficientes a los clientes, entregando ropa limpia y fresca a tiempo y según las especificaciones del cliente.</p>
    </div>
</div>
</div>
</div>

                <div id="servicios" class="tabcontent">

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
            <div id="servicios" class="tabcontent">
                <h1 style="font-size:60px">Servicios y ofertas</h1>
                <br>
                <ul style="color:black">
                <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 20px;">

    <figure>
        <img src="Images/amano.jpg" alt="Servicio 1" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Lavado a mano, ropa delicada</figcaption>
    </figure>

    <figure>
        <img src="Images/express.jpg" alt="Servicio 2" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Lavado express, entrega rápida</figcaption>
    </figure>

    <figure>
        <img src="Images/edredon.jpg" alt="Servicio 3" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Lavado de edredones y cobijas</figcaption>
    </figure>

    <figure>
        <img src="Images/planchado.jpg" alt="Servicio 4" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Planchado y doblado profesional</figcaption>
    </figure>

    <figure>
        <img src="Images/especial.jpg" alt="Servicio 5" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Lavado especial para prendas de vestir</figcaption>
    </figure>

    <figure>
        <img src="Images/envio.jpg" alt="Servicio 6" style="width: 300px; height: 200px;">
        <figcaption style="color: black; font-size: 20px; text-align: center;">Lavado y envio a domicilio</figcaption>
    </figure>

</div>
<div style="text-align: center; margin-top: 30px;">
    <p style="color: black; font-size: 20px;">
        Puedes canjear tus puntos de cliente regular para obtener ofertas especiales y más.
    </p>
    <a href="ofertas.php" style="display: inline-block; padding: 10px 20px; background-color: #1E90FF; color: white; text-decoration: none; font-size: 18px; border-radius: 5px;">Ir a ofertas</a>
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
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
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
                    <table BORDER=5 CELLSPACING=1 CELLPADDING=1 bordercolor=black>
                        <TR>
                            <TD><b><font color="black">&nbsp;nombre_usuario&nbsp;</font></b></TD>
                            <TD><b><font color="black">&nbsp;producto&nbsp;</font></b></TD>
                            <TD><b><font color="black">&nbsp;cantidad&nbsp;</font></b></TD>
                            <TD><b><font color="black">&nbsp;precio_unitario&nbsp;</font></b></TD>
                            <TD><b><font color="black">&nbsp;total&nbsp;</font></b></TD>
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
                        <table BORDER=0 CELLSPACING=1 CELLPADDING=1 bordercolor=black>
                        <TR>
                            <TD><a href="abm.php?accion=alta">Agregar</a></TD>
                            <TD><a href="abm.php?accion=modificacion">Modificar</a></TD>
                            <TD><a href="abm.php?accion=baja">Borrar</a></TD>
                            
                            </TR>
                        <br>
                        
                        <br></table>
                    </center>
                <?php } else {?>
                    <h1 style="color:black;font-size:60px">inicie sesión o registrese para visualizar esta sección</h1>
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
            
                <h1 style="font-size:60px">No dude en contactarnos para cualquier consulta o pedido!</h1>
                <div id="ubicacion">
                    <br>
                    <br>
                    <br>
                    <center><h2 style="color:black;">Ubicación: </h2></center>
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
                            <h2 style="color:black">teléfonos: 2798181 - 66522222</h2>
                            <h2 style="color:black">Correo: Ejemplo@gmail.com</h2>
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
                    Bubbles La Paz
                    <br>
                    2023
                    <br>
                    Por Fabrizio Palenque, Diego Moron, Christian Cevallos, Sebastián Pinto, Marco Quispe
                    <br>
                    <br>
                </p>
            </center>
        </div>
    </footer>
</body>

</html>