<!DOCTYPE html>
<html lang="en">
<head>
	<title>Inicio</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/liberias_ui/popper.min.js"></script>
	<script src="./js/liberias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/liberias_ui/bootstrap.min.js"></script>
</head>

<body <?php if(basename($_SERVER['PHP_SELF'],'.php')=='menu') { ?>style="background-color:#8c8c8c;"<?php } ?> >	
	<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="menu">
			<a href="menu.php" class="navbar-brand">
				<img src="favicon.ico" width="40" height="40" alt="">
			</a>
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item <?php if(basename($_SERVER['PHP_SELF'],'.php')=='libros') { ?>active"<?php }else{ ?>"<?php }?>>
					<a href="libros.php" class="nav-link">Libros</a>
				</li>
				<li class="nav-item <?php if(basename($_SERVER['PHP_SELF'],'.php')=='capitulos') { ?>active"<?php }else{ ?>"<?php }?>>
					<a href="capitulos.php" class="nav-link">Capitulos</a>
				</li>
				<li class="nav-item <?php if(basename($_SERVER['PHP_SELF'],'.php')=='clases') { ?>active"<?php }else{ ?>"<?php }?>>
					<a href="clases.php" class="nav-link">Clases</a>
				</li>
				<li class="nav-item <?php if(basename($_SERVER['PHP_SELF'],'.php')=='usuarios') { ?>active"<?php }else{ ?>"<?php }?>>
					<a href="usuarios.php" class="nav-link">Usuarios Admin</a>
				</li>												
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item <?php if(basename($_SERVER['PHP_SELF'],'.php')=='salir') { ?>active"<?php }else{ ?>"<?php }?>>
					<a href="salir.php" class="nav-link" >Salir</a>
				</li>
			</ul>
		</div>
	</nav>
</body>
</html>	