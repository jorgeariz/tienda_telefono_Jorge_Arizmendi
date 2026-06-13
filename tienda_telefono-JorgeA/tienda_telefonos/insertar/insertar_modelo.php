<?php include("../conexion.php");

$nombre = $_POST['nombre'] ?? null;
$id_marca = $_POST['id_marca'] ?? null;

if (!$nombre || !$id_marca) {
    die("Error: Todos los campos son obligatorios.");
}

$stmt = $conexion->prepare("INSERT INTO modelo (nombre, id_marca) VALUES (?, ?)");
$stmt->bind_param("si", $nombre, $id_marca);

if ($stmt->execute()) {
    header("Location: ../menu_mostrar.php?p=modelos");
    exit();
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>