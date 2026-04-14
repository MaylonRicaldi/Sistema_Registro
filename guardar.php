<?php
include("conexion.php");

$codigo = $_POST['codigo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$remitente = $_POST['remitente'] ?? '';
$despacho = $_POST['despacho'] ?? '';

if($codigo==""||$tipo==""||$fecha==""||$remitente==""||$despacho==""){
    echo "<script>alert('Faltan datos');window.location='index.html';</script>";
    exit();
}

$verificar = mysqli_query($conn,"SELECT * FROM documento WHERE codigo='$codigo'");
if(mysqli_num_rows($verificar)>0){
    echo "<script>alert('Código duplicado');window.location='index.html';</script>";
    exit();
}

mysqli_query($conn,"INSERT INTO documento 
(codigo,tipo,fecha_recepcion,remitente,id_despacho,estado)
VALUES ('$codigo','$tipo','$fecha','$remitente','$despacho','Pendiente de entrega')");

$id = mysqli_insert_id($conn);

mysqli_query($conn,"INSERT INTO seguimiento (id_documento,estado)
VALUES ($id,'Pendiente de entrega')");

header("Location: index.html");
?>