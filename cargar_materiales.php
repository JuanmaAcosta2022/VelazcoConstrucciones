<?php 
include('conexion.php');

$nombre = $_POST["nombre_material"];
$imagen = $_POST["image"];
$descripcion = $_POST["descripcion"];

mysqli_query($conexion, "INSERT INTO materiales VALUES(DEFAULT, DEFAULT, '$nombre', DEFAULT,'$imagen', '$descripcion')");

mysqli_close($conexion);

header("Location: materiales.php?ok");