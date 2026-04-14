<?php
include("conexion.php");

$id = $_POST['id'];
$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$remitente = $_POST['remitente'];
$despacho = $_POST['despacho'];

// Validaciones básicas
if(empty($id) || empty($codigo) || empty($tipo) || empty($fecha) || empty($remitente) || empty($despacho)){
    die("Error: Campos obligatorios");
}

// Actualizar
$sql = "UPDATE documento SET 
codigo='$codigo',
tipo='$tipo',
fecha_recepcion='$fecha',
remitente='$remitente',
id_despacho='$despacho'
WHERE id=$id";

if(mysqli_query($conn, $sql)){
    header("Location: index.html");
} else {
    echo "Error al actualizar: " . mysqli_error($conn);
}
?>