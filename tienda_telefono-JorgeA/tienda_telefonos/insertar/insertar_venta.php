<?php 
include("../conexion.php");

if (isset($_POST['enviar'])) {
    $id_telefono = $_POST['id_telefono'];
    $fecha_venta = $_POST['fecha_venta'];
    $cliente     = $_POST['cliente'];
    $tipo_pago   = $_POST['tipo_pago'];

    $cliente   = $conexion->real_escape_string($cliente);
    $tipo_pago = $conexion->real_escape_string($tipo_pago);

    $conexion->begin_transaction();

    try {
        $sqlVenta = "INSERT INTO venta (id_telefono, fecha_venta, cliente, tipo_pago) 
                     VALUES ('$id_telefono', '$fecha_venta', '$cliente', '$tipo_pago')";
        
        if ($conexion->query($sqlVenta) !== TRUE) {
            throw new Exception("Error al insertar la venta: " . $conexion->error);
        }

        $sqlTelefono = "UPDATE telefono SET activo = 0 WHERE id_telefono = '$id_telefono'";
        
        if ($conexion->query($sqlTelefono) !== TRUE) {
            throw new Exception("Error al actualizar el estado del teléfono: " . $conexion->error);
        }

        $conexion->commit();

        header("Location: ../menu_mostrar.php?p=venta");
        exit();

    } catch (Exception $e) {
        $conexion->rollback();
        echo "Error crítico. Operación cancelada: " . $e->getMessage();
    }
}
?>