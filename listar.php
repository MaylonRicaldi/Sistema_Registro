<?php
include("conexion.php");

$sql = "SELECT d.id,d.codigo,d.tipo,d.fecha_recepcion,d.remitente,
dp.nombre AS despacho,d.estado
FROM documento d
JOIN despacho dp ON d.id_despacho = dp.id";

$res = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}

echo json_encode($data);
?>