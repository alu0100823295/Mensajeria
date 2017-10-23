<?php

	function DameFecha($Fecha)
	{
		$F = strtotime($Fecha);
		
		return date("d-m-Y", $F) . " a las " . date("H:i", $F) . " horas.";
	}
	
	function Ejecutar($Conexion, $SQL)
	{
		$Resultado = mysqli_query($Conexion, $SQL);
		if (!$Resultado) die("Error en la ejecución");
		
		return $Resultado;
	}

	function CrearConexion()
	{
		// Lo primero es crear una conexión con la base de datos. No es necesario pero para clarificar lo asignamos a tres variables.
		// Recuerda, las variables siempre empiezan con dolar ($).
		
		$Servidor = "localhost";
		$Usuario = "root";
		$Clave = "";
		$BaseDatos = "prueba";

		// Creamos la conexión y almacenamos el handle
		
		$Conexion = new mysqli($Servidor, $Usuario, $Clave, $BaseDatos);

		// Comprobamos que la conexión es válida (la función die termina el programa mostrando un mensaje, es como un "echo" más "exit")
		
		/*if ($Conexion->connect_error) die("Fallo!! " . $Conexion->connect_error);
		echo "La conexión se ha efectuado correctamente :-D <br />";*/
		
		return $Conexion;
	}	
?>