<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ../menu_mostrar.php?p=marcas");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sql_update = "UPDATE marca SET nombre = ? WHERE id_marca = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("ss", $nombre, $id);
    $stmt->execute();
    header("Location: ../menu_mostrar.php?p=marcas");
    exit();
}

$sql_select = "SELECT * FROM marca WHERE id_marca = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("s", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Marca no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Marca</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
</head>
<body>

    <div class="card">
        <h2>Editar Marca</h2>

        <form action="editar_marca.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            
            <div class="form-group">
                <label for="nombre">Nombre de la marca</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>" required autocomplete="off">
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Guardar Cambios</button>
                <a href="../menu_mostrar.php?p=marcas" class="btn btn-cancel">Cancelar</a>
            </div>
            
        </form>
    </div>

</body>
</html>