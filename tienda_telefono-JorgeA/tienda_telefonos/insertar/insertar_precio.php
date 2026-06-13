<?php 
include("../conexion.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $precio_nuevo  = $_POST['precio_nuevo']; 
    $id_telefono   = $_POST['id_telefono'];
    $fecha_cambio  = $_POST['fecha_cambio'];

    $conexion->begin_transaction();

    try {
        $sql = "INSERT INTO precio (precio_nuevo, id_telefono, precio_anterior, fecha_cambio, activo) 
                VALUES (?, ?, ?, ?, '1')";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $precio_nuevo, $id_telefono, $precio_nuevo, $fecha_cambio);

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar el precio: " . $stmt->error);
        }
        $stmt->close();

        $sqlTelefono = "UPDATE telefono SET activo = 1 WHERE id_telefono = ?";
        $stmtTel = $conexion->prepare($sqlTelefono);
        $stmtTel->bind_param("s", $id_telefono);

        if (!$stmtTel->execute()) {
            throw new Exception("Error al actualizar el estado del teléfono: " . $stmtTel->error);
        }
        $stmtTel->close();

        $conexion->commit();

        header("Location: ../menu_mostrar.php?p=precio");
        exit(); 

    } catch (Exception $e) {
        $conexion->rollback();
        echo "Error crítico. Operación cancelada: " . $e->getMessage();
    }
}

$conexion->close();
?>