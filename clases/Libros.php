<?php

/***/
class Libros {

	public function leer($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM li_libros ORDER BY numero";
		if($inicio!=="" && $maximo!==""){
			$sql.= " LIMIT ".$inicio.", ".$maximo;
		}
		$r = mysqli_query($conn, $sql);
		$libros =  array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($libros, $row);
			}
		}

		return $libros;
	}

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM li_libros";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function baja($conn, $id){
		$sql = "DELETE FROM li_libros WHERE id=".$id;

		if (mysqli_query($conn, $sql)) {
			header("location:libros.php");
			}
		$msg = array("1Error al borrar el registro");

		return $msg;
	}

	public function registro($conn, $id){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_libros WHERE id=".$id;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function alta($conn, $id, $clave, $numero, $titulo, $subtitulo, $target){
		$msg = array();

		if ($clave=="") {
			array_push($msg, "1La clave del libro es requerida");
		}else if($numero==""){
			array_push($msg, "1El numero del libro es requerido");
		}else if($titulo==""){
			array_push($msg, "1El titulo del libro es requerido");
		}else if($subtitulo==""){
			array_push($msg, "1El subtitulo del libro es requerido");
		}else{
			if ($id=="") {
				$sql = "INSERT INTO li_libros VALUES(0,";
				$sql.= "'".$clave."', ";
				$sql.= "'".$numero."', ";
				$sql.= "'".$titulo."', ";
				$sql.= "'".$subtitulo."', ";
				$sql.= "'".$target."')";
			}else{
				$sql = "UPDATE li_libros SET ";
				$sql.= "clave='".$clave."', ";
				$sql.= "numero='".$numero."', ";
				$sql.= "titulo='".$titulo."', ";
				$sql.= "subtitulo='".$subtitulo."', ";
				$sql.= "target='".$target."' ";				
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

	/* Funciones de reportes: */
	public function leerLibro($conn, $clave){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_libros WHERE clave='".$clave."'";
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}	

}

?>