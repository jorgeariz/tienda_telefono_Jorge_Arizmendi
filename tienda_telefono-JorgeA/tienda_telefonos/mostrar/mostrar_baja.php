<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT b.id_baja, b.id_telefono, m.nombre AS modelo, ma.nombre AS marca, c.nombre_color, b.fecha_baja, b.motivo 
        FROM baja b
        INNER JOIN telefono t ON b.id_telefono = t.id_telefono
        INNER JOIN modelo m ON t.id_modelo = m.id_modelo
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        INNER JOIN color c ON t.id_color = c.id_color
        WHERE b.activo = 1";

$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Bajas de Equipos</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID Baja</th>
                    <th>ID Teléfono</th>
                    <th>Marca / Modelo</th>
                    <th>Color</th>
                    <th>Fecha de Baja</th>
                    <th>Motivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila["id_baja"]; ?></td>
                            <td><?php echo $fila["id_telefono"]; ?></td>
                            <td><?php echo $fila["marca"] . " " . $fila["modelo"]; ?></td>
                            <td><?php echo $fila["nombre_color"]; ?></td>
                            <td><?php echo $fila["fecha_baja"]; ?></td>
                            <td><?php echo $fila["motivo"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_baja.php?id=<?php echo $fila['id_baja']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_baja.php?id=<?php echo $fila['id_baja']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center; color:var(--texto-gris); padding:20px;">No hay registros de bajas registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=baja" class="btn-agregar opcion-menu">Agregar Baja</a>
    </div>
</div>