<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

// Consulta modificada: quitamos v.precio y agregamos v.cliente junto a v.tipo_pago
$sql = "SELECT v.id_venta, v.fecha_venta, v.cliente, v.tipo_pago, 
               ma.nombre AS marca, m.nombre AS modelo, c.nombre_color, 
               p.precio_nuevo AS precio_almacen
        FROM venta v
        INNER JOIN telefono t ON v.id_telefono = t.id_telefono
        INNER JOIN modelo m ON t.id_modelo = m.id_modelo
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        INNER JOIN color c ON t.id_color = c.id_color
        LEFT JOIN precio p ON t.id_telefono = p.id_telefono
        WHERE v.activo = 1";

$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Ventas</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                    <th>Precio Original</th>
                    <th>Tipo de Venta</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id_venta']; ?></td>
                        <td><?php echo htmlspecialchars($fila['cliente'] ?? 'Sin nombre'); ?></td>
                        <td><?php echo $fila['marca']; ?></td>
                        <td><?php echo $fila['modelo']; ?></td>
                        <td><?php echo $fila['nombre_color']; ?></td>
                        <td>$<?php echo number_format($fila['precio_almacen'] ?? 0, 2); ?></td>
                        <td>
                            <span class="badge-tipo-pago <?php echo ($fila['tipo_pago'] == 'Crédito') ? 'pago-credito' : 'pago-contado'; ?>">
                                <?php echo $fila['tipo_pago']; ?>
                            </span>
                        </td>
                        <td><?php echo $fila['fecha_venta']; ?></td>
                        <td>
                            <div class="bloque-acciones-lista">
                                <a href="editar/editar_venta.php?id=<?php echo $fila['id_venta']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                
                                <a href="eliminar/eliminar_venta.php?id=<?php echo $fila['id_venta']; ?>" 
                                   class="btn-lista-premium btn-eliminar-neo" 
                                   onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align:center; color:var(--texto-gris); padding:20px;">No hay registros de ventas registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=venta" class="btn-agregar opcion-menu">Agregar Venta</a>
    </div>
</div>