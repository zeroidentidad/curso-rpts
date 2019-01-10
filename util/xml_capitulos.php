<?php
require "conn.php";
$q = (isset($_GET["q"]))?$_GET["q"]:"";
$sql = "SELECT * FROM li_capitulos WHERE libro='".$q."'";
$r = mysqli_query($conn, $sql);
// Generar XML:
print header("Content-type:text/xml");
print "<?xml version='1.0' encoding='UTF-8'?>";
print "<capitulos>";
while ($datos = mysqli_fetch_object($r)){
	$numero = $datos->numero;
	$titulo = $datos->titulo;
 // crear nodo
	print "<capitulo>";
	print "<numero>".$numero."</numero>";
	print "<titulo>".$titulo."</titulo>";
	print "</capitulo>";	
}
print "</capitulos>";
mysqli_close($conn);
?>