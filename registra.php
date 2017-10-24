<html>
<head><title>Registro</title>
    <style>@import url(http://fonts.googleapis.com/css?family=Open+Sans);</style>
    <!-- Bootstrap -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <!-- End Bootstrap Include -->
    <script src="js/index.js"></script>
</head>
    <body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container justify-content-center">
            <a class="navbar-brand text-white" href="/">Bienvenido al Sistema de Mensajes</a>
        </div>
    </nav>
    <br>

    <div class="container">
        <?php
        include "Conexion.php";
        $Conexion = CrearConexion();

        $Usuario = $_REQUEST["Usuario"];
        $Clave = $_REQUEST["Clave"];
        $Correo = $_REQUEST["Correo"];

        $emailQuery = "SELECT Email FROM usuarios WHERE Email = '$Correo' LIMIT 1";
        $Exists_email = mysqli_query($Conexion, $emailQuery);

        if(mysqli_num_rows($Exists_email) == 0) {    // EMAIL NO ASIGNADO

            echo "HOLA";

            $SQL = " INSERT INTO usuarios (Usuario, Clave, Email) VALUES ( '$Usuario', '$Clave', '$Correo') ";

            if ($Conexion->query($SQL) === true) {

                $SQL = " select ID, Usuario from usuarios where Usuario = '$Usuario' and Clave = '$Clave' ";

                $Resultado = mysqli_query($Conexion, $SQL);
                $Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC);
                if ($Tupla["ID"] != "") {
                    session_start();
                    $_SESSION["USUARIO_ID"] = $Tupla["ID"];
                    $_SESSION["USUARIO_NOMBRE"] = $Tupla["Usuario"];
                    header('Location: Lista.php?Tipo=Recibidos'); //Redirigimos al listado
                } else {
                    header('Location: index.html'); // Si no hay resultado volvemos al login
                }

            } else {
                echo "
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h4 class=\"card-title\">Error al registrar usuario</h4>
                            <p class=\"card-text\">No se ha podido registar el usuario.</p>
                            <a href=\"/\" class=\"btn btn-primary\">Página de Inicio</a>
                        </div>
                    </div>
                ";

            }
        }

          // EMAIL ASIGNADO
        if(mysqli_num_rows($Exists_email) > 0) {

            echo "
                <div class=\"card text-center\">
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Error al registrar usuario</h4>
                        <p class=\"card-text\">No se ha podido registar el usuario o el usuario que ha intentado registrar ya existe.</p>
                        <a href=\"/\" class=\"btn btn-primary\">Página de Inicio</a>
            ";
        }
        ?>

    </div>
</body>
</html>