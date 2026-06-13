<?php include("../conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
} else {
    header("Location: ../menu_mostrar.php?p=precio");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $precio_anterior = $_POST['precio_anterior']; // Recibe el precio de costo
    $fecha_input = $_POST['fecha_cambio'];

    // Concatenamos la hora para el formato DATETIME
    $fecha_cambio = $fecha_input . " 00:00:00"; 

    // CORRECCIÓN: Ahora actualizamos 'precio_anterior' (Costo) en lugar de precio_nuevo
    $sql_update = "UPDATE precio SET precio_anterior = ?, fecha_cambio = ? WHERE id_telefono = ?";
    $stmt = $conexion->prepare($sql_update);
    $stmt->bind_param("dsi", $precio_anterior, $fecha_cambio, $id);
    $stmt->execute();
    
    header("Location: ../menu_mostrar.php?p=precio");
    exit();
}

$sql_select = "SELECT * FROM precio WHERE id_telefono = ?";
$stmt = $conexion->prepare($sql_select);
$stmt->bind_param("i", $id);
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();

if (!$registro) {
    echo "Registro de precio no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Precio de Costo</title>
    <link rel="stylesheet" href="../style/estilos_formularios.css">
    
    <style>
        .form-group input[type="number"],
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

        .form-group input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(72%) sepia(93%) saturate(3016%) hue-rotate(143deg) brightness(101%) contrast(101%);
            cursor: pointer;
        }

        .form-group input[type="number"]:focus,
        .form-group input[type="date"]:focus {
            outline: none;
            border-color: #00f2fe;
            background-color: rgba(20, 23, 38, 0.9);
            box-shadow: 0 0 12px rgba(0, 242, 254, 0.3);
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Editar Costo de Adquisición (Almacén)</h2>

        <form action="editar_precio.php?id=<?php echo htmlspecialchars($id ?? ''); ?>" method="POST">
            
            <div class="form-group">
                <label for="precio_anterior">Precio Costo (Almacén):</label>
                <input type="number" step="0.01" id="precio_anterior" name="precio_anterior" value="<?php echo htmlspecialchars($registro['precio_anterior'] ?? ''); ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="fecha_cambio">Fecha de Compra:</label>
                <input type="date" id="fecha_cambio" name="fecha_cambio" value="<?php echo htmlspecialchars(substr($registro['fecha_cambio'] ?? '', 0, 10)); ?>" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-submit">Guardar Cambios</button>
                <a href="../menu_mostrar.php?p=precio" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>