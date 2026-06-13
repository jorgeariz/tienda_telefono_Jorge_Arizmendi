<?php
$sql_telefonos = "SELECT t.id_telefono, m.nombre AS modelo, ma.nombre AS marca, c.nombre_color 
                  FROM telefono t
                  INNER JOIN modelo m ON t.id_modelo = m.id_modelo
                  INNER JOIN marca ma ON m.id_marca = ma.id_marca
                  INNER JOIN color c ON t.id_color = c.id_color
                  WHERE t.activo = 0";
$res_telefonos = $conexion->query($sql_telefonos);
?>

<div class="main-card-panel">
    <h1>Registrar Costo de Adquisición (Stock)</h1>

    <div class="contenedor-form" style="max-width: 520px;"> 
        <form action="insertar/insertar_precio.php" method="POST">
            
            <div>
                <label for="id_telefono">Selecciona el Teléfono comprado:</label>
                <select name="id_telefono" id="id_telefono" required>
                    <option value="">-- Seleccione un teléfono --</option>
                    <?php 
                    if ($res_telefonos && $res_telefonos->num_rows > 0) {
                        while($t = $res_telefonos->fetch_assoc()): ?>
                            <option value="<?php echo $t['id_telefono']; ?>">
                                <?php echo "ID: " . $t['id_telefono'] . " - " . $t['marca'] . " " . $t['modelo'] . " (" . $t['nombre_color'] . ")"; ?>
                            </option>
                        <?php endwhile; 
                    } else {
                        echo '<option value="">No hay teléfonos nuevos esperando asignación de costo</option>';
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="precio_anterior">Precio de Costo / Compra ($):</label>
                <input type="number" name="precio_nuevo" id="precio_anterior" step="0.01" min="0.00" placeholder="0.00" required>
            </div>

            <div>
                <label for="fecha_cambio">Fecha de Compra:</label>
                <input type="date" name="fecha_cambio" id="fecha_cambio" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" name="enviar" class="btn-agregar">Guardar Costo de Stock</button>
            </div>
        </form>
    </div>
</div>