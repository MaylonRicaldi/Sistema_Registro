<?php
include("conexion.php");

$sql = "SELECT 
d.codigo,
d.tipo,
d.fecha_recepcion,
d.remitente,
dp.nombre AS despacho,
d.estado
FROM documento d
JOIN despacho dp ON d.id_despacho = dp.id";

$result = mysqli_query($conn, $sql);

$datos = [];

while($row = mysqli_fetch_assoc($result)){
    $datos[] = $row;
}

echo json_encode($datos);
?>