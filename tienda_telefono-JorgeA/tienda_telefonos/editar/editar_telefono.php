<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: ../menu_mostrar.php?p=telefono");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_color       = $_POST['id_color'];
    $fecha_registro = $_POST['fecha_registro'];
    $estado         = $_POST['estado'];
    $precio         = $_POST['precio']; 

    $sql_update_tel = "UPDATE telefono SET id_color = ?, fecha_registro = ?, estado = ?, precio_actual = ? WHERE id_telefono = ?";
    $stmt_tel = $conexion->prepare($sql_update_tel);
    $stmt_tel->bind_param("sssdi", $id_color, $fecha_registro, $estado, $precio, $id);
    $stmt_tel->execute();

    $sql_check = "SELECT id_telefono, precio_nuevo FROM precio WHERE id_telefono = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result()->fetch_assoc();

    if ($res_check) {
        $precio_anterior = $res_check['precio_nuevo'];
        $sql_update_precio = "UPDATE precio SET precio_anterior = ?, precio_nuevo = ?, fecha_cambio = NOW() WHERE id_telefono = ?";
        $stmt_pr = $conexion->prepare($sql_update_precio);
        $stmt_pr->bind_param("ddi", $precio_anterior, $precio, $id); 
        $stmt_pr->execute();
    } else {
        $sql_insert_precio = "INSERT INTO precio (precio_nuevo, id_telefono, precio_anterior, fecha_cambio, activo) VALUES (?, ?, 0.00, NOW(), '1')";
        $stmt_pr = $conexion->prepare($sql_insert_precio);
        $stmt_pr->bind_param("di", $precio, $id);
        $stmt_pr->execute();
    }

    header("Location: ../menu_mostrar.php?p=telefono");
    exit();
}

$sql_select = "SELECT t.*, m.nombre AS modelo, ma.nombre AS marca 
               FROM telefono t 
               INNER JOIN modelo m ON t.id_modelo = m.id_modelo
               INNER JOIN marca ma ON m.id_marca = ma.id_marca
               WHERE t.id_telefono = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Teléfono no encontrado.";
    exit();
}

$sql_cols = "SELECT * FROM color";
$res_cols = $conexion->query($sql_cols);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Teléfono</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
    <style>
        body { overflow-y: auto !important; align-items: flex-start !important; padding-top: 5vh; padding-bottom: 5vh; }
        .form-group select, .form-group input { 
            width: 100%; padding: 16px; 
            background-color: rgba(20, 23, 38, 0.7); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 10px; 
            color: #ffffff; 
            font-size: 1rem; 
            transition: all 0.3s ease; 
        }
        .form-group input:disabled { 
            background-color: rgba(10, 11, 18, 0.5); 
            color: #888888; 
            border-color: rgba(255, 255, 255, 0.05); 
            cursor: not-allowed; 
        }
        .form-group select { 
            appearance: none; 
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2300f2fe' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>"); 
            background-repeat: no-repeat; 
            background-position: right 16px center; 
            background-size: 16px; 
            cursor: pointer; }
        .form-group select:focus, 
        .form-group input:not(:disabled):focus { 
            outline: none; 
            border-color: #00f2fe; 
            background-color: rgba(20, 23, 38, 0.9); 
            box-shadow: 0 0 12px rgba(0, 242, 254, 0.3); 
        }
        .form-group select option { 
            background-color: #0b0c10; color: #ffffff; 
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>EDITAR REGISTRO DE TELÉFONO</h2>
        <form action="editar_telefono.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <div class="form-group">
                <label>MODELO / MARCA (NO EDITABLE):</label>
                <input type="text" value="<?php echo htmlspecialchars($registro['marca'] . " " . $registro['modelo']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>IMEI (NO EDITABLE):</label>
                <input type="text" value="<?php echo htmlspecialchars($registro['IMEI']); ?>" disabled>
            </div>
            <div class="form-group">
                <label for="precio">PRECIO DE VENTA ($):</label>
                <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($registro['precio_actual']); ?>" required>
            </div>
            <div class="form-group">
                <label for="id_color">COLOR:</label>
                <select id="id_color" name="id_color" required>
                    <?php while($c = $res_cols->fetch_assoc()): ?>
                        <option value="<?php echo $c['id_color']; ?>" <?php if($c['id_color'] == $registro['id_color']) echo "selected"; ?>>
                            <?php echo htmlspecialchars($c['nombre_color']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_registro">FECHA DE REGISTRO:</label>
                <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo $registro['fecha_registro']; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">ESTADO:</label>
                <select id="estado" name="estado" required>
                    <option value="En venta" <?php if($registro['estado'] == 'En venta') echo 'selected'; ?>>En venta</option>
                    <option value="Dañado / Defectuoso" <?php if($registro['estado'] == 'Dañado / Defectuoso') echo 'selected'; ?>>Dañado / Defectuoso</option>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-submit">GUARDAR CAMBIOS</button>
                <a href="../menu_mostrar.php?p=telefono" class="btn btn-cancel">CANCELAR</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php $conexion->close(); ?>