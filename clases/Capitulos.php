<?php

/***/
class Capitulos {

	public function leer($conn, $inicio, $maximo){
		$sql = "SELECT * FROM li_capitulos ORDER BY libro, numero LIMIT ".$inicio.", ".$maximo;
		$r = mysqli_query($conn, $sql);
		$salida =  array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($salida, $row);
			}
		}

		return $salida;
	}

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM li_capitulos";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function baja($conn, $id){
		$sql = "DELETE FROM li_capitulos WHERE id=".$id;

		if (mysqli_query($conn, $sql)) {
			header("location:capitulos.php");
			}
		$msg = array("1Error al borrar el registro");

		return $msg;
	}

	public function registro($conn, $id){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_capitulos WHERE id=".$id;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function alta($conn, $id, $libro, $numero, $titulo, $objetivo, $introduccion){
		$msg = array();

		if ($libro=="") {
			array_push($msg, "1La clave del libro es requerida");
		}else if($numero==""){
			array_push($msg, "1El numero del capitulo es requerido");
		}else if($titulo==""){
			array_push($msg, "1El titulo del capitulo es requerido");
		}else if($objetivo==""){
			array_push($msg, "1El objetivo del capitulo es requerido");
		}else{
			if ($id=="") {
				$sql = "INSERT INTO li_capitulos VALUES(0,";
				$sql.= "'".$libro."', ";
				$sql.= "'".$numero."', ";
				$sql.= "'".$titulo."', ";
				$sql.= "'".$objetivo."', ";
				$sql.= "'".$introduccion."')";
			}else{
				$sql = "UPDATE li_capitulos SET ";
				$sql.= "libro='".$libro."', ";
				$sql.= "numero='".$numero."', ";
				$sql.= "titulo='".$titulo."', ";
				$sql.= "objetivo='".$objetivo."', ";
				$sql.= "introduccion='".$introduccion."' ";				
				$sql.= "WHERE id=".$id;				
			}

			if (mysqli_query($conn, $sql)) {
				array_push($msg, "0Guardado correcto");
			}else{
				array_push($msg, "1Error en el guardado");
			}

			return $msg;
		}		

	}

	public function	capitulosLibro($conn, $libro){
		$sql = "SELECT numero, titulo FROM li_capitulos WHERE libro='".$libro."'";
		$r = mysqli_query($conn, $sql);
		$datos = array();
		while ($row = mysqli_fetch_assoc($r)) {
			array_push($datos, $row);
		}
		return $datos;
	}

	/* Funciones de reportes: */
	public function leerCapitulo($conn, $libro, $numero){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_capitulos WHERE libro='".$libro."' AND numero='".$numero."'";
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function leerCapitulosLibro($conn, $libro){
		//$datos = "1Error al obtener el registro";
		$datos = array();
		$sql = "SELECT * FROM li_capitulos ";
		$sql.= "WHERE libro='".$libro."'";
		$r = mysqli_query($conn, $sql);
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($datos, $row);
			}
		}
		return $datos ;
	}			

}

?>