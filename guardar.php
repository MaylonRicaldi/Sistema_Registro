<?php
include("conexion.php");

// RECIBIR DATOS
$codigo = $_POST['codigo'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$remitente = $_POST['remitente'] ?? '';
$despacho = $_POST['despacho'] ?? '';

// VALIDAR CAMPOS VACÍOS
if($codigo=="" || $tipo=="" || $fecha=="" || $remitente=="" || $despacho==""){
    echo "<script>alert('⚠️ Todos los campos son obligatorios'); window.location='index.html';</script>";
    exit();
}

// VALIDAR FORMATO DEL CÓDIGO
if(!preg_match("/^DOC[0-9]{3}$/", $codigo)){
    echo "<script>alert('⚠️ Código inválido (Ej: DOC001)'); window.location='index.html';</script>";
    exit();
}

// VALIDAR DUPLICADO
$verificar = mysqli_query($conn, "SELECT id FROM documento WHERE codigo='$codigo'");
if(mysqli_num_rows($verificar) > 0){
    echo "<script>alert('⚠️ El código ya existe'); window.location='index.html';</script>";
    exit();
}

// INSERTAR DOCUMENTO
$sql = "INSERT INTO documento 
(codigo, tipo, fecha_recepcion, remitente, id_despacho, estado)
VALUES 
('$codigo', '$tipo', '$fecha', '$remitente', '$despacho', 'Pendiente de entrega')";

if(mysqli_query($conn, $sql)){

    // OBTENER ID
    $id = mysqli_insert_id($conn);

    // GUARDAR SEGUIMIENTO
    mysqli_query($conn, "INSERT INTO seguimiento (id_documento, estado)
    VALUES ($id, 'Pendiente de entrega')");

    header("Location: index.html");

} else {
    echo "Error: " . mysqli_error($conn);
}
?>