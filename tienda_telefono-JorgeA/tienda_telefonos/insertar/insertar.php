<?php include("../conexion.php");

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    $stmt = $conexion->prepare("INSERT INTO marca (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre);

    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=marcas");
        exit(); 
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>