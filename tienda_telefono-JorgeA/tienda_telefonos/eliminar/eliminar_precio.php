<?php 
include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conexion->begin_transaction();

    try {
        $stmtPre = $conexion->prepare("UPDATE precio SET activo = 0 WHERE id_telefono = ?");
        $stmtPre->bind_param("i", $id);
        
        if (!$stmtPre->execute()) {
            throw new Exception("Error al eliminar el costo de adquisición: " . $stmtPre->error);
        }
        $stmtPre->close();

        $stmtTel = $conexion->prepare("UPDATE telefono SET activo = 0 WHERE id_telefono = ?");
        $stmtTel->bind_param("i", $id);

        if (!$stmtTel->execute()) {
            throw new Exception("Error al desactivar el teléfono del inventario: " . $stmtTel->error);
        }
        $stmtTel->close();

        $conexion->commit();

        header("Location: ../menu_mostrar.php?p=precio");
        exit();

    } catch (Exception $e) {
        $conexion->rollback();
        echo "Error crítico. Operación cancelada: " . $e->getMessage();
    }
} else {
    header("Location: ../menu_mostrar.php?p=precio");
    exit();
}

$conexion->close();
?>