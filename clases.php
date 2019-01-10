<?php
require "util/sesion.php";
require "util/conn.php";
require "util/variables_globales.php";
require "clases/Clases.php";
require "clases/Capitulos.php";
require "clases/Libros.php";

$clases = new Clases();
$num = $clases->numeroRegistros($conn);

require "util/variables_paginacion.php";

/*** Catalogo de libros ***/
$libros = new Libros();
$libros_array = $libros->leer($conn,0,999);
$capitulos = new Capitulos();
$capitulos_array = array();
/*Modo de pagina ($_GET["modo"])
S - Consulta (select)
A - Alta (insert)
B - Baja (pantalla de confirmacion registro)
C - Cambio (update)
D - Baja definitiva (delete)
*/

/** Variables de alta **/
$id = "";
$libro = "";
$capitulo = "";
$clase = "";
$indice = "";
$titulo = "";
$texto = "";
$video = "";
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
	$msg = $clases->baja($conn, $id);
}

// Deteccion Alta por medio de un isset
if (isset($_POST["libro"])){
	//
	$id = (isset($_POST["id"]))?$_POST["id"]:"";
	$libro = $_POST["libro"];
	$capitulo = $_POST["capitulo"];
	$clase = $_POST["clase"];
	$indice = $_POST["indice"];
	$titulo = $_POST["titulo"];
	$texto = addslashes(htmlentities($_POST["content"]));
	$video = $_POST["video"];
	//
	$msg = $clases->alta($conn, $id, $libro, $capitulo, $clase, $indice, $titulo, $texto, $video);
}

// Modo consulta general tabla paginada
if ($modo=="S") {
	$datos = $clases->leer($conn, $inicio_p, $TAMANO_PAGINA);
}

// Modo cambio en registro
if ($modo=="C" || $modo=="B") {
	$id = $_GET["id"];
	$datos = $clases->registro($conn, $id);
	//
	//paso datos del GET
	$libro = $datos["libro"];
	$capitulo = $datos["capitulo"];
	$clase = $datos["clase"];
	$indice = $datos["indice"];
	$titulo = $datos["titulo"];
	$texto = $datos["texto"];
	$video = $datos["video"];	
	// leemos los capitulos del libro seleccionado para el combo por PHP
	$capitulos_array = $capitulos->capitulosLibro($conn, $libro);
	//print var_dump($capitulos_array);
}

 // Evitar cache de JS y otros
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Clases</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="./js/liberias_ui/popper.min.js"></script>
	<script src="./js/liberias_ui/jquery-3.3.1.slim.min.js"></script>	
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/liberias_ui/bootstrap.min.js"></script>
	<script src="./js/ckeditor5/ckeditor.js"></script>
	<!-- JS-CSS JAFS -->
	<link rel="stylesheet" href="./css/estilos.css">	
	<script type="text/javascript"><?php require "./js/clases_js.php"; ?></script>	
</head>

<body>
	<?php require "menu.php" ?>

	<div class="container-fluid text-center">
		<div class="row content">
			<div class="col-sm-2 sidenav mt-5">
				<?php if($modo=="S"){ ?>
					<label for="alta"></label>
					<input type="button" name="alta" value="Alta nueva clase" class="btn btn-info" role="button" id="alta">
				<?php } ?>				
			</div>
			<div class="col-sm-8 text-center">
				<h2>Clases <?php print "(".$num.")"; ?></h2>
				<?php
				if($modo=="A" || $modo=="C" || $modo=="B"){
				require "util/mensajes.php";
				?>
				<form class="text-left" action="clases.php" method="post">
					<div class="form-group">
						<label for="libro">*Libro:</label><br>
						<select <?php if($modo=="B") print 'disabled'; ?> id="libro" name="libro" required>
						<option value="">-Seleccionar libro-</option>
						<?php
							for($i = 0; $i<count($libros_array); $i++){
								$l = $libros_array[$i]["numero"]." ";
								$l.= $libros_array[$i]["clave"]."-";
								$l.= $libros_array[$i]["titulo"];
								print "<option value='";
								print $libros_array[$i]["clave"]."' ";
								if($libros_array[$i]["clave"]==$libro) print "selected";
								print ">".$l;
								print "</option>";
							}
						?>
						</select>
					</div>
					<div class="form-group">
						<label for="capitulo">*Capitulo:</label><br>
						<select <?php if($modo=="B") print 'disabled'; ?> id="capitulo" name="capitulo" required>
							<option value="">-Seleccionar un capitulo-</option>
							<?php
								for($i = 0; $i<count($capitulos_array); $i++){
									$c = $capitulos_array[$i]["numero"].") ";
									$c.= $capitulos_array[$i]["titulo"];
									print "<option value='";
									print $capitulos_array[$i]["numero"]."' ";
									if($capitulos_array[$i]["numero"]==$capitulo) print "selected";
									print ">".$c;
									print "</option>";
								}
							?>							
						</select>
					</div>					
					<div class="form-group">
						<label for="clase">*Clase:</label>
						<input type="text" name="clase" id="clase" class="form-control" required placeholder="El numero de la clase"
						value="<?php print $clase; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>		
					<div class="form-group">
						<label for="indice">Indice:</label>
						<input type="text" name="indice" id="indice" class="form-control" placeholder="El numero de indice de la clase"
						value="<?php print $indice; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>									
					<div class="form-group">
						<label for="titulo">*Titulo:</label>
						<input type="text" name="titulo" id="titulo" class="form-control" required placeholder="El titulo de la clase"
						value="<?php print $titulo; ?>" <?php if($modo=="B") print 'disabled'; ?>
						/>
					</div>
					<div class="form-group">
						<label for="editor">*Texto:</label>
						<textarea name="content" id="editor" <?php if($modo=="B") print 'disabled'; ?> rows="10" required>
							<?php print $texto; ?>
						</textarea>
					</div>
					<div class="form-group">
						<label for="video">Video:</label>
						<input type="text" name="video" id="video" class="form-control" placeholder="El video del capitulo"
						value="<?php print $video; ?>" <?php if($modo=="B") print 'disabled'; ?>
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
					print '<th>Libro</th>';
					print '<th>Capitulo</th>';
					print '<th>Clase</th>';
					print '<th>Titulo</th>';
					print '<th>Modificar</th>';
					print '<th>Borrar</th>';
					print '<th>Imprimir</th>';
					print '</tr>';
					for ($i=0; $i < count($datos); $i++) { 
					print '<tr>';
					print '<td>'.$datos[$i]["libro"].'</td>';
					print '<td>'.$datos[$i]["capitulo"].'</td>';
					print '<td>'.$datos[$i]["clase"].'</td>';
					print '<td class="text-left">'.$datos[$i]["titulo"].'</td>';
					print '<td><a class="btn btn-info" href="clases.php?modo=C&id='.$datos[$i]["id"].'">M</a></td>';
					print '<td><a class="btn btn-warning" href="clases.php?modo=B&id='.$datos[$i]["id"].'">B</a></td>';
					print '<td><a class="btn btn-outline-secondary" href="reportes/clase_rpt.php?clase='.$datos[$i]["clase"].'&capitulo='.$datos[$i]["capitulo"].'&libro='.$datos[$i]["libro"].'">PDF</a></td>';
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
 <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>