<?php include("../conexion.php");

$nombre = $_POST['nombre_color'];
$sql = "INSERT INTO color (nombre_color) VALUES ('$nombre')";

if ($conexion->query($sql) === TRUE) {
    header("Location: ../menu_mostrar.php?p=colores");
    exit(); 
} else {
    echo "Error al guardar: " . $conexion->error;
}

$conexion->close();
?>