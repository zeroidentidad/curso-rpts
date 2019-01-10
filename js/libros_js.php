window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("alta").onclick = function (){
			window.open("libros.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id = <?php print $id; ?>;
			window.open("libros.php?modo=D&id="+id, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("libros.php", "_self");
		}		
	<?php } else { ?>
		document.getElementById("regresar").onclick = function (){
			window.open("libros.php", "_self");
		}
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("libros.php?p="+p, "_self");
}