<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("UPDATE modelo SET activo = 0 WHERE id_modelo = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=modelos");
        exit();
    } else {
        echo "Error al eliminar el modelo: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    header("Location: ../menu_mostrar.php?p=modelos");
    exit();
}

$conexion->close();
?>