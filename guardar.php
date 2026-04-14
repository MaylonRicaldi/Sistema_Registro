<?php
include("conexion.php");

// Obtener datos seguro
$numero = isset($_POST['numero']) ? $_POST['numero'] : "";
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$remitente = $_POST['remitente'];
$despacho = $_POST['despacho'];

// VALIDACIONES
if($numero === "" || empty($tipo) || empty($fecha) || empty($remitente) || empty($despacho)){
    die("Error: Todos los campos son obligatorios");
}

if(!is_numeric($numero)){
    die("Error: El número debe ser numérico");
}

// Generar código
$codigo = "DOC" . str_pad($numero, 3, "0", STR_PAD_LEFT);

// Validar duplicado
$verificar = mysqli_query($conn, "SELECT id FROM documento WHERE codigo='$codigo'");
if(mysqli_num_rows($verificar) > 0){
    echo "<script>
        alert('Código ya existe');
        window.location='index.html';
    </script>";
    exit();
}

// Validaciones extra
$tipos_validos = ["Oficio","Carta","Memorando","Informe"];
if(!in_array($tipo, $tipos_validos)){
    die("Tipo inválido");
}

// INSERT
$sql = "INSERT INTO documento 
(codigo, tipo, fecha_recepcion, remitente, id_despacho, estado)
VALUES 
('$codigo', '$tipo', '$fecha', '$remitente', '$despacho', 'Pendiente de entrega')";

if(mysqli_query($conn, $sql)){

    $id = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO seguimiento (id_documento, estado)
    VALUES ($id, 'Pendiente de entrega')");

    header("Location: index.html");

} else {
    echo "ERROR SQL: " . mysqli_error($conn);
}
?>