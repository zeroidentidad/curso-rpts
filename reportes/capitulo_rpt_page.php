<?php
require "../util/conn.php";
require "../clases/Clases.php";
require "../clases/Capitulos.php";
require "../clases/Libros.php";

$libros = new Libros();
$capitulos = new Capitulos();
$clases = new Clases();
//
$libros_array = $libros->leerLibro($conn, $libro);
$capitulos_array = $capitulos->leerCapitulo($conn, $libro, $capitulo);
$clases_array = $clases->leerClases($conn, $libro, $capitulo);

// Evitar cache de JS y otros
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en pasado
?>
<style>
	*{margin:0; padding: 0;}
	table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    h1 {color: #000033}
    h2 {color: #000055}
    h3 {color: #000077}
    div.nivel,p{
		padding-left: 5mm;
		font-size: 18px;
		text-align: justify;
		line-height: 20pt;
    }
</style>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt" backimg="../imgs/logo.fw.png">
	<h1 style="text-align: center;">
		<?php print $libros_array["titulo"]; ?>
	</h1>
	<h3 style="text-align: center;">
		<?php print $libros_array["subtitulo"]; ?>
	</h3>
	<?php
		$t = "Capitulo ".$capitulos_array["numero"].": ".$capitulos_array["titulo"];
		print '<bookmark title="'.$t.'" level="0"></bookmark>';
		print '<br><h3>'.$t.'</h3>';
		//print '<img src="../imgs/logo.png" style="margin-left: -15mm;">';
		print '<br><p><b>Objetivo:</b> '.html_entity_decode($capitulos_array["objetivo"]).'</p>';
		print '<br><p><b>Introducción:</b> '.html_entity_decode($capitulos_array["introduccion"]).'</p>';
	?>
</page>
	<?php
		for ($i=0; $i < count($clases_array) ; $i++) {
	?>
		<!-- pageset="old" heredar de la pag anterior conf estilos, diseño-->	
		<page backtop="16mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt" backimg="">
			<page_header>
				<table class="page_header">
					<tr>
						<td style="width: 100%; text-align: center;">
							<h1><?php print $libros_array["titulo"]; ?></h1>
						</td>
					</tr>
				</table>
			</page_header>
			<page_footer>
				<table class="page_footer">
					<tr>
						<td style="width: 33%; text-align: left;">
							Autor: 
						</td>
						<td style="width: 34%; text-align: center;">
							página [[page_cu]] de [[page_nb]]
						</td>
						<td style="width: 33%; text-align: right;">
							<a>softcun.co.nf</a>
						</td>												
					</tr>
				</table>				
			</page_footer>
	<?php	
			$t = $clases_array[$i]["capitulo"].".".$clases_array[$i]["clase"];
			$t.= ". ".$clases_array[$i]["titulo"];
			print '<br><br>';
			print '<bookmark title="'.$t.'" level="1"></bookmark>';
			print '<h2>'.$t.'</h2>';
			print '<br>';
			print "<div class='nivel'>";
			print html_entity_decode($clases_array[$i]["texto"]);
			print '<br>';
			print '<p style="text-align: right;">Video: '.$clases_array[$i]["video"]."</p>";
			print "</div>";
			print '</page>';
		}
	?>