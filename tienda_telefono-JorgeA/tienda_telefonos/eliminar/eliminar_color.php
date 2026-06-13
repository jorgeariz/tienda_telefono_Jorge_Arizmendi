<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $stmt = $conexion->prepare("UPDATE color SET activo = 0 WHERE id_color = ?");
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=colores");
        exit();
    } else {
        echo "Error al eliminar el color: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    header("Location: ../menu_mostrar.php?p=colores");
    exit();
}

$conexion->close();
?>