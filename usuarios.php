<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Usuarios.php";

$usuario_ = new Usuarios();
$num = $usuario_->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*Modo de pagina ($_GET["modo"])
S - Consulta (select)
A - Alta (insert)
B - Baja (pantalla de confirmacion registro)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de alta **/
$id = "";
$clave = "";
$usuario = "";
//

//Validaciones modos:

if (isset($_GET["modo"])) {
	$modo = $_GET["modo"];
} else {
	$modo = "S";
}

// Delete definitivo
if ($modo=="D") {
	$id = $_GET["id"];
	$msg = $usuario_->baja($conn, $id);
}

// Deteccion Alta por medio de un isset
if (isset($_POST["clave"])){
	//
	$id = (isset($_POST["id"]))?$_POST["id"]:"";
	$clave = $_POST["clave"];
	$clave2 = $_POST["clave2"];
	$usuario = $_POST["usuario"];
	//
	$clave = substr(hash_hmac("sha512", $clave, "keyxyz"),0,50);
	$clave2 = substr(hash_hmac("sha512", $clave2, "keyxyz"),0,50);
	//

	if ($clave==$clave2) {
		$msg = $usuario_->alta($conn, $id, $usuario, $clave);
	} else {
		array_push($msg, "1Las claves no coinciden");
		$modo = ($id=="")?"A":"C";
	}

}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $usuario_->leer($conn, $inicio_p, $TAMANO_PAGINA);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id = (isset($_GET["id"]))?$_GET["id"]:$id;
	$datos = $usuario_->registro($conn, $id);
	//
	//paso datos del GET
	$clave = $datos["clave"];
	$usuario = $datos["usuario"];
	//	
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Usuarios Admin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/liberias_ui/popper.min.js"></script>
	<script src="./js/liberias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/liberias_ui/bootstrap.min.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/usuarios_js.php"; ?></script>
</head>

<body>
	<?php require "menu.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<label for="alta"></label>
					<input type="button" name="alta" value="Alta nuevo usuario" class="btn btn-info" role="button" id="alta">
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Usuarios <?php print "(".$num.")"; ?></h2>
				<?php
				if($modo=="A" || $modo=="C" || $modo=="B"){
				require "util/mensajes.php";
				?>
				<form class="text-left" action="usuarios.php" method="post">
					<div class="form-group">
						<label for="usuario">*Usuario (evitar espacios):</label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="El nombre de usuario sin espacios"
						value="<?php print $usuario; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>
					<div class="form-group">
						<label for="clave">*Clave:</label>
						<input type="password" name="clave" id="clave" class="form-control" required placeholder="La clave (contaseña) de acceso" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>
					<div class="form-group">
						<label for="clave2">*Verificar clave:</label>
						<input type="password" name="clave2" id="clave2" class="form-control" required placeholder="Verifica la clave de acceso" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>					

					<!-- Campos ocultos necesarios: -->
					<input type="hidden" name="id" id="id" value="<?php print $id; ?>" />
					<!-- -------------------------- -->

					<div class="form-group">
						<?php if($modo=="A" || $modo=="C"){ ?>
						<label for="enviar"></label>
						<input type="submit" name="enviar" id="enviar" class="btn btn-success" role="button" value="Enviar" />
						<label for="regresar"></label>
						<input type="button" name="regresar" id="regresar" class="btn btn-info" role="button" value="Regresar" />
						<?php } 

						if($modo=="B"){
						?>
						<label for="si-borrar">¿Desea borrar el registro?</label>
						<input type="button" name="si-borrar" id="si-borrar" class="btn btn-danger" role="button" value="Si" />
						<input type="button" name="no-borrar" id="no-borrar" class="btn btn-danger" role="button" value="No" />
						<p>Una vez borrado el registro NO se podra recuperar.</p>
						<?php } ?>
					</div>									
				</form>
				<?php }

				if ($modo=="S") {
					print '<table class="table table-striped" with="100%">';
					print '<tr>';
					print '<th>Usuario</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["usuario"].'</td>';
					print '<td><a class="btn btn-info" href="usuarios.php?modo=C&id='.$datos[$i]["id"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="usuarios.php?modo=B&id='.$datos[$i]["id"].'">B</a></td>';
					print '</tr>';
					}
					print '</table>';

					/**** PAGINACION TABLA ****/
					require "util/paginar_tabla_html.php";
					
				}

				?>
			</div>
			<div class="col-sm-2 sidenav"></div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>