<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ../menu_mostrar.php?p=colores");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_color = $_POST['nombre_color'];
    $sql_update = "UPDATE color SET nombre_color = ? WHERE id_color = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("ss", $nombre_color, $id); 
    $stmt->execute();

    // Redirección corregida hacia el menú unificado
    header("Location: ../menu_mostrar.php?p=colores");
    exit();
}

$sql_select = "SELECT * FROM color WHERE id_color = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("s", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Color no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Color</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
</head>
<body>

    <div class="card">
        <h2>Editar Color</h2>

        <form action="editar_color.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            
            <div class="form-group">
                <label for="nombre_color">Nombre del color:</label>
                <input type="text" id="nombre_color" name="nombre_color" value="<?php echo htmlspecialchars($registro['nombre_color']); ?>" required autocomplete="off">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Guardar Cambios</button>
                <a href="../menu_mostrar.php?p=colores" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>