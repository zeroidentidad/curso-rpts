<?php

/***/
class Clases {

	public function leer($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM li_clases ORDER BY libro, capitulo, clase, indice";
		if($inicio!="" && $maximo!=""){
			$sql.= " LIMIT ".$inicio.", ".$maximo;
		}
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
		$sql = "SELECT COUNT(*) AS num FROM li_clases";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function baja($conn, $id){
		$sql = "DELETE FROM li_clases WHERE id=".$id;

		if (mysqli_query($conn, $sql)) {
			header("location:clases.php");
			}
		$msg = array("1Error al borrar el registro");

		return $msg;
	}

	public function registro($conn, $id){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_clases WHERE id=".$id;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function alta($conn, $id, $libro, $capitulo, $clase, $indice, $titulo, $texto, $video){
		$msg = array();

		if ($libro=="") {
			array_push($msg, "1La clave del libro es requerida");
		}else if($capitulo==""){
			array_push($msg, "1El capitulo del libro es requerido");
		}else if($clase==""){
			array_push($msg, "1El numero de clase es requerido");
		}else if($titulo==""){
			array_push($msg, "1El titulo de la clase es requerido");
		}else if($texto==""){
			array_push($msg, "1El texto de la clase es requerido");
		}else{
			if ($id=="") {
				$sql = "INSERT INTO li_clases VALUES(0,";
				$sql.= "'".$libro."', ";
				$sql.= "'".$capitulo."', ";
				$sql.= "'".$clase."', ";
				$sql.= "'".$indice."', ";
				$sql.= "'".$titulo."', ";
				$sql.= "'".$texto."', ";
				$sql.= "'".$video."')";
			}else{
				$sql = "UPDATE li_clases SET ";
				$sql.= "libro='".$libro."', ";
				$sql.= "capitulo='".$capitulo."', ";
				$sql.= "clase='".$clase."', ";
				$sql.= "indice='".$indice."', ";
				$sql.= "titulo='".$titulo."', ";
				$sql.= "texto='".$texto."', ";				
				$sql.= "video='".$video."' ";				
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
	public function leerClases($conn, $libro, $capitulo){
		$datos = "1Error al obtener las clases";
		$sql = "SELECT * FROM li_clases ";
		$sql.= "WHERE libro='".$libro."' AND ";
		$sql.= "capitulo='".$capitulo."'";
		$sql.= "ORDER BY libro, capitulo, clase";
		$r = mysqli_query($conn, $sql);
		$salida = array();
		if ($r) {
			while($row = mysqli_fetch_assoc($r)){
				array_push($salida, $row);
			}
		}
		return $salida;
	}

	public function leerClasesLibro($conn, $libro, $capitulo, $clase){
		$salida = "1Error al obtener las clases";
		$sql = "SELECT * FROM li_clases ";
		$sql.= "WHERE libro='".$libro."' AND ";
		$sql.= "capitulo='".$capitulo."' AND ";
		$sql.= "clase='".$clase."' ";
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$salida = mysqli_fetch_assoc($r);
		}
		return $salida;
	}			

}

?>