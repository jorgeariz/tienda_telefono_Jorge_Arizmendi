<?php
$imei_aleatorio = mt_rand(1000000, 9999999) . mt_rand(10000000, 99999999);

$res_modelos = $conexion->query("SELECT id_modelo, nombre FROM modelo");
$res_colores = $conexion->query("SELECT id_color, nombre_color FROM color");
?>

<div class="main-card-panel">
    <h1>Registrar Teléfono</h1>

    <div class="contenedor-form">
        <form action="insertar/insertar_telefono.php" method="POST">
            
            <div>
                <label>Selecciona el Modelo:</label>
                <select name="id_modelo" required>
                    <option value="">Seleccione un modelo</option>
                    <?php while($m = $res_modelos->fetch_assoc()): ?>
                        <option value="<?php echo $m['id_modelo']; ?>">
                            <?php echo $m['id_modelo'] . " - " . $m['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label>IMEI:</label>
                <input type="text" name="imei" value="<?php echo $imei_aleatorio; ?>" readonly>
            </div>

            <div>
                <label>Selecciona el Color:</label>
                <select name="id_color" required>
                    <option value="">Seleccione un color</option>
                    <?php while($c = $res_colores->fetch_assoc()): ?>
                        <option value="<?php echo $c['id_color']; ?>">
                            <?php echo $c['id_color'] . " - " . $c['nombre_color']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label>Precio de Venta ($):</label>
                <input type="number" name="precio_actual" step="0.01" min="0.00" placeholder="0.00" required>
            </div>

            <div>
                <label>Fecha de Registro:</label>
                <input type="date" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div>
                <label>Estado del equipo:</label>
                <select name="estado" required>
                    <option value="En venta" selected>En venta</option>
                    <option value="Dañado / Defectuoso">Dañado / Defectuoso</option>
                </select>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" name="enviar" class="btn-agregar">Guardar Teléfono</button>
            </div>
        </form>
    </div>
</div>