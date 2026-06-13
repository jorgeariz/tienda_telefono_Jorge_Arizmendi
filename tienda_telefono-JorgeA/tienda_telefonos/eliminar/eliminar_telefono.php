<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexion->prepare("UPDATE telefono SET activo = 0 WHERE id_telefono = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=telefono");
        exit();
    } else {
        echo "Error al eliminar el teléfono: " . $stmt->error;
    }
    $stmt->close();
} else {
    header("Location: ../menu_mostrar.php?p=telefono");
    exit();
}

$conexion->close();
?>