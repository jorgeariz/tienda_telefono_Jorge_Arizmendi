<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexion->prepare("UPDATE marca SET activo = 0 WHERE id_marca = ?");
    $stmt->bind_param("i", $id); 
    
    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=marcas");
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
} else {
    header("Location: ../mostrar/buscar_marca.php");
}

$conexion->close();
?>