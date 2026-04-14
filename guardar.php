<?php
include("conexion.php");

// Obtener datos
$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$remitente = $_POST['remitente'];
$despacho = $_POST['despacho'];

// ================= VALIDACIONES =================

// 1. Campos obligatorios
if(empty($codigo) || empty($tipo) || empty($fecha) || empty($remitente) || empty($despacho)){
    die("Error: Todos los campos son obligatorios");
}

// 2. Código formato DOC001
if(!preg_match("/^DOC[0-9]{3}$/", $codigo)){
    die("Error: El código debe tener formato DOC001");
}

// 3. Código único
$verificar = mysqli_query($conn, "SELECT id FROM documento WHERE codigo='$codigo'");
if(mysqli_num_rows($verificar) > 0){
    die("Error: El código ya existe");
}

// 4. Tipo válido
$tipos_validos = ["Oficio","Carta","Memorando","Informe"];
if(!in_array($tipo, $tipos_validos)){
    die("Error: Tipo de documento inválido");
}

// 5. Fecha válida
if(!strtotime($fecha)){
    die("Error: Fecha inválida");
}

// 6. Remitente solo letras
if(!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/", $remitente)){
    die("Error: El remitente solo debe contener letras");
}

// 7. Despacho válido (solo 4)
$despachos_validos = [1,2,3,4];
if(!in_array($despacho, $despachos_validos)){
    die("Error: Despacho inválido");
}

// ================= INSERT =================

$sql = "INSERT INTO documento 
(codigo, tipo, fecha_recepcion, remitente, id_despacho, estado)
VALUES 
('$codigo', '$tipo', '$fecha', '$remitente', '$despacho', 'Pendiente de entrega')";

if(mysqli_query($conn, $sql)){

    // Obtener ID insertado
    $id = mysqli_insert_id($conn);

    // Insertar seguimiento
    mysqli_query($conn, "INSERT INTO seguimiento (id_documento, estado)
    VALUES ($id, 'Pendiente de entrega')");

    // Redirigir
    header("Location: index.html");

} else {
    echo "Error al registrar: " . mysqli_error($conn);
}
?>