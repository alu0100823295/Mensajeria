<html>
<head><title>Listado de mensajes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</head>
<body>
    <script>
        function Eliminar(ID)
        {
            if (confirm("Haga clic en Aceptar para eliminar el mensaje definitivamente"))
            {
                document.location.href="?Accion=Eliminar&ID=" + ID;
            }
        }

    </script>
    <?php
        include "Conexion.php";

        session_start();

        $Conexion = CrearConexion();

        $Accion = $_REQUEST["Accion"];  // Inicialmente no existe.
        $Usuario = $_SESSION["USUARIO_ID"];
        $Nombre = $_SESSION["USUARIO_NOMBRE"];
        $ID = $_REQUEST["ID"];          // Inicialmente no existe.

        echo "
            <nav class=\"navbar navbar-dark bg-dark\">
                <div class=\"container justify-content-center\">
                    <a class=\"navbar-brand text-white\" href=\"/\">Bienvenido/a $Nombre</a>
                </div>
            </nav>
            <br/>
            <div class=\"container\">
        ";

        if ($Accion == "") $Accion = "Recibidos";
        if ($Accion == "Insertar" || $Accion == "Modificar")
        {
            $Para = $_REQUEST["Para"];
            $Mensaje = $_REQUEST["Mensaje"];

            if ($Accion == "Insertar")
                $SQL = "insert into mensajes (Usuario, Para, Mensaje) values ($Usuario, $Para, '$Mensaje')";
            else
                $SQL = "update mensajes set Usuario = $Usuario, Para = $Para, Mensaje = '$Mensaje' where id = $ID";

            Ejecutar($Conexion, $SQL);
            $Accion = "Recibidos";
        }

        if ($Accion == "Eliminar" && $ID != "")
        {
            Ejecutar($Conexion, "delete from mensajes where id = $ID and (Para = $Usuario or Usuario = $Usuario)");
        }

        if ($Conexion)
        {
            $SDE = $_REQUEST["SDE"];
            $SMensaje = $_REQUEST["SMensaje"];

            $SQL = "select * from usuarios where ID <> $Usuario order by Usuario";
            $Resultado = Ejecutar($Conexion, $SQL);

            echo "
                <form method=\"post\">
                    <div class=\"form-group\">
            
                        <div class=\"row\">
                            <legend><strong>Busquedas en $Accion</strong></legend>
                        </div>
                        <div class=\"row\">
                            <div class=\"col align-self-center\">
            ";
            if ($Accion == "Recibidos") echo "De "; else echo "Para ";
            echo "
                            </div>
                            <div class=\"col\">
                                <select name='SDE' class='form-control'>
                                    <option value=\"\"></option>
            ";

            // Desplegable con nombres de usuarios excepto el propio
            while ($RTemp = mysqli_fetch_array($Resultado))
            {
                echo ("<option value='". $RTemp["ID"]."'");
                if ($RTemp["ID"] == $SDE)  echo (" selected='selected'");
                echo (">" . $RTemp["Usuario"] . "</option>");
            }
            echo "
                                </select>
                            </div>
                            <div class=\"col align-self-center\">Mensaje</div>
                            <div class=\"col\">
                                <input type=\"text\" class='form-control' name=\"SMensaje\" value=\"$SMensaje\" />
                            </div>
                        </div>
                        <hr/>
                        <div class=\"row justify-content-center\">
                            <button class=\"btn btn-outline-dark\" type=\"submit\" name=\"Accion\" value=\"$Accion\">Buscar</button>
                            &nbsp;
                            <button class=\"btn btn-outline-dark\" type=\"button\" onclick=\"javascript:location.href = '/Lista.php?Accion=Recibidos'\">Recibidos</button>
                            &nbsp;
                            <button class=\"btn btn-outline-dark\" type=\"button\" onclick=\"javascript:location.href = '/Lista.php?Accion=Enviados'\">Enviados</button>
                        </div>
                    </div>
                </form>
            ";
            ?>
<!--
            <li>Mensaje</li><li><input type="text" class='form-control' name="SMensaje" value="<?php /*echo $SMensaje; */?>" /></li>
            <li><button class="btn btn-outline-dark" type="submit" name="Accion" value="<?php /*$Accion */?>">Buscar</button></li>
            <li><div class="btn btn-outline-dark" onclick="javascript:location.href='?Accion=Recibidos'">Recibidos</div></li>
            <li><div class="btn btn-outline-dark" onclick="javascript:location.href='?Accion=Enviados'">Enviados</div></li>
            </body>
            </div></form>
-->
            <?php

            if ($Accion == "Recibidos")
            {
                $SQL = "SELECT mensajes.ID as ID, Mensaje, usuarios.Usuario as Remitente, Fecha FROM mensajes left join usuarios on mensajes.usuario = usuarios.id ";
                $SQL .= " where mensajes.Para = $Usuario ";
                if ($SDE != "") $SQL .= " and mensajes.usuario = $SDE ";

            }
            else
            {
                $SQL = "SELECT mensajes.ID as ID, Mensaje, usuarios.Usuario as Destinatario, Fecha FROM mensajes left join usuarios on mensajes.Para = usuarios.id ";
                $SQL .= " where mensajes.Usuario = $Usuario";
                if ($SDE != "") $SQL .= " and mensajes.Para = $SDE ";
            }

            if ($SMensaje != "") $SQL .= " and Mensaje like '%$SMensaje%' ";
            $SQL .= " order by id desc";

            $Resultado = Ejecutar($Conexion, $SQL);


            echo "<hr/>";
            echo "<div class='container'>";

            $bg = ["bg-info", "bg-dark"];

            $index = 0;

            while ($Tupla = mysqli_fetch_array($Resultado ,MYSQLI_ASSOC))
            {
                echo "<div class='card text-center'>";


                if ($Accion == "Recibidos")
                    echo "<div class='card-header ". $bg[$index] ." text-white'>Mensaje de " . $Tupla["Remitente"] . "</div>";
                else
                    echo "<div class='card-header ". $bg[$index] ." text-white'>Mensaje enviado a " . $Tupla["Destinatario"] . "</div>";

                if($index == 0) $index = 1;
                else $index = 0;

                echo "<div class=\"card-body\"";
                echo "<p>" . str_replace("\n", "<br />", $Tupla["Mensaje"]) . "</p>\n";


                echo "<button class=\"btn btn-outline-dark\"";
                if ($Accion == "Recibidos") echo (" hidden ");
                echo " onclick=\"javascript:location.href='Mensaje.php?Accion=Editar&ID=".$Tupla["ID"]."'\">Editar</button>&nbsp;";
                echo "<button class=\"btn btn-outline-dark\" onclick=\"javascript:Eliminar(".$Tupla["ID"].")\">Eliminar</button>";
                echo "</div>";

                echo "<div class=\"card-footer bg-white text-right\">Recibido el " . DameFecha($Tupla["Fecha"]) . "</div>";
                echo "</div><hr/>";
            }

            echo "<div class='d-flex justify-content-center'><button class=\"btn btn-outline-dark\" type=\"button\" onclick=\"javascript:location.href='/Mensaje.php'\">Nuevo mensaje</button>\n";
            echo "</div>";
        }
        mysqli_close($Conexion);

    ?>
</body>
</html>
