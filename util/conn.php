<?php
$_host = "localhost";
$_usuario = "root";
$_clave = "jafs2050";
$_db = "libros";
$_puertos = "3306";
$conn = mysqli_connect($_host, $_usuario, $_clave, $_db, $_puertos) or die("No hay conexión a la base de datos");
?>