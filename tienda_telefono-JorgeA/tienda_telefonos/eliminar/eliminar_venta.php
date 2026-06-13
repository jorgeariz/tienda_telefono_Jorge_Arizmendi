<?php 
include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conexion->begin_transaction();

    try {
        $sqlBuscar = "SELECT id_telefono FROM venta WHERE id_venta = ?";
        $stmtBus = $conexion->prepare($sqlBuscar);
        $stmtBus->bind_param("i", $id);
        $stmtBus->execute();
        $res = $stmtBus->get_result();
        
        if ($res->num_rows === 0) {
            throw new Exception("La venta no existe.");
        }
        
        $venta = $res->fetch_assoc();
        $id_telefono = $venta['id_telefono'];
        $stmtBus->close();

        $stmtVen = $conexion->prepare("UPDATE venta SET activo = 0 WHERE id_venta = ?");
        $stmtVen->bind_param("i", $id);
        
        if (!$stmtVen->execute()) {
            throw new Exception("Error al eliminar la venta: " . $stmtVen->error);
        }
        $stmtVen->close();

        $stmtTel = $conexion->prepare("UPDATE telefono SET activo = 1 WHERE id_telefono = ?");
        $stmtTel->bind_param("i", $id_telefono);

        if (!$stmtTel->execute()) {
            throw new Exception("Error al regresar el teléfono al inventario: " . $stmtTel->error);
        }
        $stmtTel->close();

        $conexion->commit();

        header("Location: ../menu_mostrar.php?p=venta");
        exit();

    } catch (Exception $e) {
        $conexion->rollback();
        echo "Error crítico. Operación cancelada: " . $e->getMessage();
    }
} else {
    header("Location: ../menu_mostrar.php?p=venta");
    exit();
}

$conexion->close();
?>