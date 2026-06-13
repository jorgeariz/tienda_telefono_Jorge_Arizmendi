<?php
$sql_telefonos = "SELECT t.id_telefono, m.nombre AS modelo, ma.nombre AS marca, c.nombre_color 
                  FROM telefono t
                  INNER JOIN modelo m ON t.id_modelo = m.id_modelo
                  INNER JOIN marca ma ON m.id_marca = ma.id_marca
                  INNER JOIN color c ON t.id_color = c.id_color";

$res_telefonos = $conexion->query($sql_telefonos);
?>

<div class="main-card-panel">
    <h1>Registrar Baja de Equipo</h1>

    <div class="contenedor-form" style="max-width: 520px;"> <form action="insertar/insertar_baja.php" method="POST">
            
            <div>
                <label for="id_telefono">Selecciona el Teléfono:</label>
                <select name="id_telefono" id="id_telefono" required>
                    <option value="">-- Seleccione un teléfono --</option>
                    <?php while($t = $res_telefonos->fetch_assoc()): ?>
                        <option value="<?php echo $t['id_telefono']; ?>">
                            <?php echo $t['id_telefono'] . " - " . $t['marca'] . " " . $t['modelo'] . " (" . $t['nombre_color'] . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="fecha_baja">Fecha de Baja:</label>
                <input type="date" name="fecha_baja" id="fecha_baja" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div>
                <label for="motivo_baja">Motivo de la Baja:</label>
                <input type="text" name="motivo" id="motivo_baja" placeholder="Ej. Defecto de fábrica, Pantalla rota, Pérdida..." required>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" name="enviar" class="btn-agregar">Registrar Baja</button>
            </div>
            
        </form>
    </div>
</div>