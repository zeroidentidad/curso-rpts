<?php
require "util/conn.php";
require "util/variables_globales.php";
if (isset($_POST["usuario"])){
	$usuario = $_POST["usuario"];
	$clave = $_POST["clave"];
	/* inicio sesion: */
	session_start();
	/* variable de sesion: */
	$_SESSION["login"] = $usuario;
	$clave = substr(hash_hmac("sha512", $clave, "keyxyz"), 0,50);
	/* consulta BD: */
	$sql = "SELECT * FROM li_usuarios WHERE usuario='".$usuario."' AND clave='".$clave."'";
	$r = mysqli_query($conn, $sql);
	$n = mysqli_num_rows($r);
	if($n==1){
		header("location:app.php");
	} else{
		array_push($msg, "1Clave de acceso o usuario incorrectos");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Acceder</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/liberias_ui/popper.min.js"></script>
	<script src="./js/liberias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/liberias_ui/bootstrap.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark" img=>
		<a href="index.php" class="navbar-brand">
			<img src="favicon.ico" width="40" height="40" alt="">
		</a>
	</nav>
	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav"></div>
			<div class="col-sm-8 text-center">
				<h2>Iniciar sesión</h2>
				<?php require "util/mensajes.php"; ?>
				<form class="text-left" action="index.php" method="post">
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Escribe tu usuario">
					</div>
					<div class="form-group">
						<label for="clave">Clave de acceso:</label>
						<input type="password" name="clave" id="clave" class="form-control" required placeholder="Escribe tu clave">
					</div>
					<div class="form-group">
						<label for="entrar"></label>
						<input type="submit" name="entrar" id="entrar" class="btn btn-success" role="button" value="Entrar">
					</div>										
				</form>
			</div>
			<div class="col-sm-2 sidenav"></div>
		</div>
	</div>

	<?php require "footer.php";?>
</body>
</html>