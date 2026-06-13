<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ../menu_mostrar.php?p=venta");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_telefono = $_POST['id_telefono'];
    $cliente     = $_POST['cliente'];
    $tipo_pago   = $_POST['tipo_pago'];
    $fecha_venta = $_POST['fecha_venta'];

    // Sanitizar textos para evitar errores en la consulta
    $cliente   = $conexion->real_escape_string($cliente);
    $tipo_pago = $conexion->real_escape_string($tipo_pago);

    // Consulta SQL limpia y actualizada sin la columna precio
    $sql_update = "UPDATE venta SET id_telefono = ?, cliente = ?, tipo_pago = ?, fecha_venta = ? WHERE id_venta = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("ssssi", $id_telefono, $cliente, $tipo_pago, $fecha_venta, $id);
    $stmt->execute();
    
    header("Location: ../menu_mostrar.php?p=venta");
    exit();
}

// Obtenemos el registro de venta con las nuevas columnas
$sql_select = "SELECT * FROM venta WHERE id_venta = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Registro de venta no encontrado.";
    exit();
}

$sql_tels = "SELECT t.id_telefono, m.nombre AS modelo, ma.nombre AS marca 
             FROM telefono t 
             INNER JOIN modelo m ON t.id_modelo = m.id_modelo 
             INNER JOIN marca ma ON m.id_marca = ma.id_marca";
$res_tels = $conexion->query($sql_tels);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Venta</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
    
    <style>
        body {
            overflow-y: auto !important;
            align-items: flex-start !important;
            padding-top: 5vh;
            padding-bottom: 5vh;
        }

        .form-group select,
        .form-group input[type="text"],
        .form-group input[type="date"] {
            width: 100%;
            padding: 16px;
            background-color: rgba(20, 23, 38, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2300f2fe' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

        .form-group input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(72%) sepia(93%) saturate(3016%) hue-rotate(143deg) brightness(101%) contrast(101%);
            cursor: pointer;
        }

        .form-group select:focus,
        .form-group input[type="text"]:focus,
        .form-group input[type="date"]:focus {
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
        <h2>Editar Registro de Venta</h2>

        <form action="editar_venta.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            
            <div class="form-group">
                <label for="id_telefono">Teléfono:</label>
                <select id="id_telefono" name="id_telefono" required>
                    <?php while($t = $res_tels->fetch_assoc()): ?>
                        <option value="<?php echo $t['id_telefono']; ?>" <?php if($t['id_telefono'] == $registro['id_telefono']) echo "selected"; ?>>
                            <?php echo htmlspecialchars($t['marca'] . " " . $t['modelo']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cliente">Nombre del Cliente:</label>
                <input type="text" id="cliente" name="cliente" value="<?php echo htmlspecialchars($registro['cliente'] ?? ''); ?>" placeholder="Nombre completo" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="tipo_pago">Tipo de Venta:</label>
                <select id="tipo_pago" name="tipo_pago" required>
                    <option value="Contado" <?php if(($registro['tipo_pago'] ?? '') == 'Contado') echo 'selected'; ?>>Contado</option>
                    <option value="Crédito" <?php if(($registro['tipo_pago'] ?? '') == 'Crédito') echo 'selected'; ?>>Crédito</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_venta">Fecha de Venta:</label>
                <input type="date" id="fecha_venta" name="fecha_venta" value="<?php echo $registro['fecha_venta']; ?>" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Guardar Cambios</button>
                <a href="../menu_mostrar.php?p=venta" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>