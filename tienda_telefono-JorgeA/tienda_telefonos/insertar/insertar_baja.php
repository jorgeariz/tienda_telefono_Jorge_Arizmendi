<?php include("../conexion.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_telefono = $_POST['id_telefono'];
    $fecha_baja  = $_POST['fecha_baja'];
    $motivo      = $_POST['motivo'];

    $stmt = $conexion->prepare("INSERT INTO baja (id_telefono, fecha_baja, motivo) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_telefono, $fecha_baja, $motivo);

    if ($stmt->execute()) {
        header("Location: ../menu_mostrar.php?p=baja");
        exit(); 
    } else {
        echo "Error al registrar la baja: " . $stmt->error;
    }

    $stmt->close();
}
$conexion->close();
?>