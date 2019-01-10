window.onload = function(){
	<?php if ($modo=="S"){ ?>
		document.getElementById("alta").onclick = function (){
			window.open("clases.php?modo=A", "_self");
		}
	<?php } else if($modo=="B"){ ?>
		document.getElementById("si-borrar").onclick = function (){
			var id = <?php print $id; ?>;
			window.open("clases.php?modo=D&id="+id, "_self");
		}
		document.getElementById("no-borrar").onclick = function (){
			window.open("clases.php", "_self");
		}		
	<?php } else { ?>
			document.getElementById("regresar").onclick = function (){
				window.open("clases.php", "_self");
			}
			document.getElementById("libro").onchange = function(){
				var libro = this.value;
				leerCapitulos(libro);
			}		
	<?php } ?>			
}
function cambiaPagina(p){
	window.open("clases.php?p="+p, "_self");
}
function leerCapitulos(libro){
	if (libro.length==0) { return; }

	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	} else {
		// IE 5 - 6
		xmlhttp = new ActiveXObject("Microsoft.HMLHTTP");
		alert("Tu navegador no soporta XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		// capturar estado 4 con 200
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200){
				procesaArchivo(xmlhttp.responseXML);
			} else {
				alert("Error en lectura datos. Error: "+xmlhttp.status);
			}
		}
	}
	// GET o POST, url, true => Asincrono false => Sincrono 
	xmlhttp.open("GET","util/xml_capitulos.php?q="+libro,true);
	// ejecutar lectura
	xmlhttp.send();
}
function procesaArchivo(objetoXML){
	var a = objetoXML.documentElement.getElementsByTagName("capitulo");
	var capitulo_combo = document.getElementById("capitulo");
	// limpiar combo:
	while(capitulo_combo.length) capitulo_combo.remove(0);
	//
	var option = document.createElement("option");
	option.innerHTML="-Seleccionar capitulo-";
	option.setAttribute("value","0");
	capitulo_combo.appendChild(option);
	// Aqui agregar valores del objeto:

	for (var i = 0; i < a.length; i++){ 
		num = a[i].getElementsByTagName("numero");
		numCadena = num[0].firstChild.nodeValue;
		//
		tit = a[i].getElementsByTagName("titulo");
		titCadena = tit[0].firstChild.nodeValue;
		//
		var option = document.createElement("option");
		option.innerHTML = numCadena+") "+titCadena;
		option.setAttribute("value",numCadena);
		capitulo_combo.appendChild(option);	
	}	
}