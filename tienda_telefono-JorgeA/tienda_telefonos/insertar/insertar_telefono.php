<?php include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_modelo     = $_POST['id_modelo'];
    $imei          = $_POST['imei'];
    $id_color      = $_POST['id_color'];
    $precio_actual = $_POST['precio_actual']; 
    $fecha         = $_POST['fecha_registro'];
    $estado        = $_POST['estado'];

    $stmt = $conexion->prepare("INSERT INTO telefono (id_modelo, IMEI, id_color, precio_actual, fecha_registro, estado, activo) VALUES (?, ?, ?, ?, ?, ?, '1')");
    $stmt->bind_param("isidss", $id_modelo, $imei, $id_color, $precio_actual, $fecha, $estado);

    if ($stmt->execute()) {
        $id_telefono_nuevo = $conexion->insert_id;
        $stmt_precio = $conexion->prepare("INSERT INTO precio (precio_nuevo, id_telefono, precio_anterior, fecha_cambio, activo) VALUES (?, ?, 0.00, NOW(), '1')");
        $stmt_precio->bind_param("di", $precio_actual, $id_telefono_nuevo);
        $stmt_precio->execute();
        $stmt_precio->close();

        header("Location: ../menu_mostrar.php?p=telefono");
        exit();
    } else {
        echo "Error al guardar: " . $stmt->error;
    }
    
    $stmt->close();
}
$conexion->close();
?>