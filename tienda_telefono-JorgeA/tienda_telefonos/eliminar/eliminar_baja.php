<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexion->prepare("UPDATE baja SET activo = 0 WHERE id_baja = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=baja");
        exit();
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
} else {
    header("Location: ../menu_mostrar.php?p=baja");
    exit();
}

$conexion->close();
?>