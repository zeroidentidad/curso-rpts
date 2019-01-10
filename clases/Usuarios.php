<?php

/***/
class Usuarios {

	public function leer($conn, $inicio="", $maximo=""){
		$sql = "SELECT * FROM li_usuarios ORDER BY usuario";
		if($inicio!=="" && $maximo!==""){
			$sql.= " LIMIT ".$inicio.", ".$maximo;
		}
		$r = mysqli_query($conn, $sql);
		$arreglo = array();

		if ($r) {
			while ($row = mysqli_fetch_assoc($r)) {
				array_push($arreglo, $row);
			}
		}

		return $arreglo;
	}

	public function numeroRegistros($conn){
		$num = 0;
		$sql = "SELECT COUNT(*) AS num FROM li_usuarios";
		$r = mysqli_query($conn, $sql);

		if ($r) {
			$row = mysqli_fetch_assoc($r);
			$num = $row["num"];
			}

		return $num;
	}	

	public function baja($conn, $id){
		$sql = "DELETE FROM li_usuarios WHERE id=".$id;

		if (mysqli_query($conn, $sql)) {
			header("location:usuarios.php");
			}
		$msg = array("1Error al borrar el registro");

		return $msg;
	}

	public function registro($conn, $id){
		$datos = "1Error al obtener el registro";
		$sql = "SELECT * FROM li_usuarios WHERE id=".$id;
		$r = mysqli_query($conn, $sql);
		if ($r) {
			$datos = mysqli_fetch_assoc($r);
			}
		return $datos ;
	}

	public function alta($conn, $id, $usuario, $clave){
		$msg = array();

		if ($clave=="") {
			array_push($msg, "1La clave del usuario es requerida");
		} else if($usuario==""){
			array_push($msg, "1El nombre (login) de usuario es requerido");
		} else {
			if ($id=="") {
				$sql = "INSERT INTO li_usuarios VALUES(0,";
				$sql.= "'".$usuario."', ";
				$sql.= "'".$clave."')";
			}else{
				$sql = "UPDATE li_usuarios SET ";
				$sql.= "usuario='".$usuario."', ";
				$sql.= "clave='".$clave."' ";				
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

}

?>