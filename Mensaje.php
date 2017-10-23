<html>
<head>
    <title>Mensaje</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include "Conexion.php";

        session_start();

        $Conexion = CrearConexion();
        $Usuario = $_SESSION["USUARIO_ID"];
        $Nombre = $_SESSION["USUARIO_NOMBRE"];
        if ($Usuario == "") header("Location: index.php"); // Derecho al login, si no sé quien eres.

        echo "
            <nav class=\"navbar navbar-dark bg-dark\">
                <div class=\"container justify-content-center\">
                    <a class=\"navbar-brand text-white\" href=\"/\">Bienvenido/a $Nombre</a>
                </div>
            </nav>
            <br/>
            <div class=\"container justify-content-center\">
            ";

        $Boton = "Insertar";

        if ($Conexion)
        {
            $Accion = $_REQUEST["Accion"];
            $ID = $_REQUEST["ID"];

            if ($Accion == "Editar" && $ID != "")
            {
                $SQL = "select * from mensajes where Id = $ID ";
                $Resultado = Ejecutar($Conexion, $SQL);
                $Tupla = mysqli_fetch_array($Resultado ,MYSQLI_ASSOC);
                $Fecha = $Tupla["Fecha"];
                $De = $Tupla["Usuario"];
                $Para = $Tupla["Para"];
                $Mensaje = $Tupla["Mensaje"];
                $Boton = "Modificar";
            }
        }
    ?>

	<form action="Lista.php" method="post">
		<?php 
			$SQL = "select * from usuarios where ID <> $Usuario order by Usuario asc";
			$Resultado = Ejecutar($Conexion, $SQL);
			echo "
                <div class='card text-center'>
                    <div class='card-header'>
                        <h3>Mensaje</h3>
                    </div>
                    <div class='card-body'>
                        <div class='row form-group align-self-center'>
                            <label class='col-sm-2 col-form-label'>Para &nbsp</label>
                            <div class='col-sm-10'>
                                <select name='Para' class='form-control'>";
			while ($RTemp = mysqli_fetch_array($Resultado)) 
			{
				echo ("<option value='". $RTemp["ID"]."'");
				if ($RTemp["ID"] == $Para)  echo (" selected='selected'");
				echo (">" . $RTemp["Usuario"] . "</option>");
			}

			echo "
                                </select>
                            </div>
                        </div>
                        <div class='row form-group align-self-center'>
                            <label class='col-sm-2 col-form-label'>Mensaje &nbsp</label>
                            <div class='col-sm-10'>
                                <textarea class='form-control' name=\"Mensaje\">$Mensaje</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class='d-flex justify-content-center'>
                    <button class=\"btn btn-outline-dark\" type=\"submit\" name=\"Accion\" value=\"$Boton\">$Boton</button>
                </div>
                
            </form>
            
        ";
		?>

<!--
		<div class='Separador'>&nbsp;</div>
		<div class="Etiqueta">Mensaje</div><div class="Valor"><textarea class='TA_Mensaje' name="Mensaje"><?php //echo $Mensaje; ?></textarea></div>
		<input type="hidden" name="ID" value="<?php //echo $ID;?>">
		<div class='Separador'>&nbsp;</div>
		<div><button class="btn btn-outline-dark" type="submit" name="Accion" value="<?php //echo $Boton; ?>"><?php //echo $Boton; ?></button></div>
		</div>

-->
</body>
</html>
