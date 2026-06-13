<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ../menu_mostrar.php?p=modelos");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_modelo = $_POST['nombre'];
    $id_marca      = $_POST['id_marca'];

    $sql_update = "UPDATE modelo SET nombre = ?, id_marca = ? WHERE id_modelo = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("sss", $nombre_modelo, $id_marca, $id);
    $stmt->execute();

    header("Location: ../menu_mostrar.php?p=modelos");
    exit();
}

$sql_select = "SELECT * FROM modelo WHERE id_modelo = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("s", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Modelo no encontrado.";
    exit();
}

$sql_marcas = "SELECT id_marca, nombre FROM marca";
$res_marcas = $conexion->query($sql_marcas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Modelo</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
    
    <style>
        .form-group select {
            width: 100%;
            padding: 16px;
            background-color: rgba(20, 23, 38, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            appearance: none; 
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2300f2fe' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

        .form-group select:focus {
            outline: none;
            border-color: #00f2fe;
            background-color: rgba(20, 23, 38, 0.9);
            box-shadow: 0 0 12px rgba(0, 242, 254, 0.3);
        }

        .form-group select option {
            background-color: #0b0c10;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Editar Modelo</h2>

        <form action="editar_modelo.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            
            <div class="form-group">
                <label for="nombre">Nombre del modelo:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro['nombre']); ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="id_marca">Marca:</label>
                <select id="id_marca" name="id_marca" required>
                    <?php while($m = $res_marcas->fetch_assoc()): ?>
                        <option value="<?php echo $m['id_marca']; ?>" <?php if($m['id_marca'] == $registro['id_marca']) echo "selected"; ?>>
                            <?php echo htmlspecialchars($m['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Guardar Cambios</button>
                <a href="../menu_mostrar.php?p=modelos" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>
<?php $conexion->close(); ?>