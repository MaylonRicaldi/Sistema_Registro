<?php
include("conexion.php");

$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$remitente = $_POST['remitente'];
$despacho = $_POST['despacho'];

// Insertar documento
$sql = "INSERT INTO documento 
(codigo, tipo, fecha_recepcion, remitente, id_despacho, estado)
VALUES 
('$codigo', '$tipo', '$fecha', '$remitente', '$despacho', 'Pendiente de entrega')";

if(mysqli_query($conn, $sql)){

    // Obtener ID del documento insertado
    $id = mysqli_insert_id($conn);

    // Guardar en seguimiento
    mysqli_query($conn, "INSERT INTO seguimiento (id_documento, estado)
    VALUES ($id, 'Pendiente de entrega')");

    header("Location: ../frontend/index.html");

} else {
    echo "Error al registrar";
}
?>