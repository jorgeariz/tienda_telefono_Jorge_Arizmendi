<?php
$sql_telefonos = "SELECT t.id_telefono, m.nombre AS modelo, ma.nombre AS marca, c.nombre_color, p.precio_nuevo AS precio_almacen
                  FROM telefono t
                  INNER JOIN modelo m ON t.id_modelo = m.id_modelo
                  INNER JOIN marca ma ON m.id_marca = ma.id_marca
                  INNER JOIN color c ON t.id_color = c.id_color
                  INNER JOIN precio p ON t.id_telefono = p.id_telefono
                  WHERE t.activo = 1";

$res_telefonos = $conexion->query($sql_telefonos);
?>

<div class="main-card-panel">
    <h1>Registrar Venta</h1>

    <div class="contenedor-form" style="max-width: 560px;"> 
        <form action="insertar/insertar_venta.php" method="POST">
            
            <div>
                <label for="id_telefono">Selecciona el Teléfono:</label>
                <select name="id_telefono" id="id_telefono" required>
                    <option value="">-- Seleccione un teléfono --</option>
                    <?php while($t = $res_telefonos->fetch_assoc()): ?>
                        <option value="<?php echo $t['id_telefono']; ?>">
                            <?php echo $t['id_telefono'] . " - " . $t['marca'] . " " . $t['modelo'] . " (" . $t['nombre_color'] . ") - $" . number_format($t['precio_almacen'], 2); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="cliente">Nombre del Cliente:</label>
                <input type="text" name="cliente" id="cliente" placeholder="Nombre completo del cliente" required>
            </div>

            <div>
                <label for="tipo_pago">Tipo de Venta:</label>
                <select name="tipo_pago" id="tipo_pago" required>
                    <option value="Contado">Contado</option>
                    <option value="Crédito">Crédito</option>
                </select>
            </div>

            <div>
                <label for="fecha_venta">Fecha de Venta:</label>
                <input type="date" name="fecha_venta" id="fecha_venta" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" name="enviar" class="btn-agregar">Guardar Venta</button>
            </div>
            
        </form>
    </div>
</div>