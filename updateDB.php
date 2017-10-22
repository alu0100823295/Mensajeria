<?php
include "Conexion.php";

$Conexion = CrearConexion();

for ( $i=1;$i<=4;$i++ ) {

    $SQL = " select * from usuarios where ID = '$i' ";
    mysqli_query($Conexion, $SQL);
    $Resultado = mysqli_query($Conexion, $SQL);
    $Tupla = mysqli_fetch_array($Resultado ,MYSQLI_ASSOC);

    $Clave = sha1($TUPLA["Clave"]);

    $SQL = " UPDATE usuarios SET Clave='$Clave' WHERE ID= '$i' ";

    $Conexion->query($SQL);

    echo "Base de Datos Actualizada";

}
?>


