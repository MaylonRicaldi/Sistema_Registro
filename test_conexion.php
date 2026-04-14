<?php
$host = "localhost";
$usuario = "root";
$password = "";
$bd = "sistema_documentos";

// Conexión
$conn = mysqli_connect($host, $usuario, $password, $bd);

// Verificar
if (!$conn) {
    die("❌ Error de conexión: " . mysqli_connect_error());
}

echo "✅ Conexión exitosa a la base de datos";

// Probar consulta simple
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

echo "<br><br>📋 Tablas encontradas:<br>";

while($row = mysqli_fetch_array($result)){
    echo "➡ " . $row[0] . "<br>";
}
?>