<?php
include("conexion.php");

$documentos = $_POST['documentos'] ?? [];

if(empty($documentos)){
    echo "<script>alert('Seleccione documentos'); window.location='index.html';</script>";
    exit();
}

// OBTENER DESPACHO (todos deben ser iguales)
$id_doc = $documentos[0];

$res = mysqli_query($conn, "SELECT id_despacho FROM documento WHERE id=$id_doc");
$data = mysqli_fetch_assoc($res);

$id_despacho = $data['id_despacho'];

// GENERAR NUMERO GUIA
$q = mysqli_query($conn, "SELECT MAX(id) as max_id FROM guia_remito");
$r = mysqli_fetch_assoc($q);

$num = $r['max_id'] + 1;
$numero_guia = "GUIA-" . str_pad($num, 4, "0", STR_PAD_LEFT);

// INSERTAR GUIA
mysqli_query($conn, "INSERT INTO guia_remito (numero_guia, fecha, id_despacho)
VALUES ('$numero_guia', NOW(), '$id_despacho')");

$id_guia = mysqli_insert_id($conn);

// INSERTAR DETALLE + ACTUALIZAR ESTADO
foreach($documentos as $doc){

    mysqli_query($conn, "INSERT INTO detalle_guia (id_guia, id_documento)
    VALUES ($id_guia, $doc)");

    mysqli_query($conn, "UPDATE documento SET estado='Cargo de envio' WHERE id=$doc");

    mysqli_query($conn, "INSERT INTO seguimiento (id_documento, estado)
    VALUES ($doc, 'Cargo de envio')");
}

echo "<script>alert('Guía generada: $numero_guia'); window.location='index.html';</script>";
?>