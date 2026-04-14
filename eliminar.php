<?php
include("conexion.php");

$id = $_POST['id'];

if(empty($id)){
    die("ID inválido");
}

// Primero eliminar seguimiento (por FK)
mysqli_query($conn, "DELETE FROM seguimiento WHERE id_documento=$id");

// Luego eliminar documento
$sql = "DELETE FROM documento WHERE id=$id";

if(mysqli_query($conn, $sql)){
    echo "Eliminado";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<script>
function eliminar(id){
    if(confirm("¿Seguro que deseas eliminar este documento?")){
        fetch("eliminar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}`
        })
        .then(() => location.reload());
    }
}
</script>