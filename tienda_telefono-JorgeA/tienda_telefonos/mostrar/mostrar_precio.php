<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT p.id_telefono, 
               ma.nombre AS marca, 
               m.nombre AS modelo, 
               p.precio_anterior AS precio_costo, 
               t.precio_actual AS precio_venta,    
               (t.precio_actual - p.precio_anterior) AS ganancia_estimada,
               p.fecha_cambio AS fecha_compra 
        FROM precio p
        INNER JOIN telefono t ON p.id_telefono = t.id_telefono
        INNER JOIN modelo m ON t.id_modelo = m.id_modelo
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        WHERE p.activo = 1";

$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Costos de Adquisición (Stock)</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID Teléfono</th>
                    <th>Equipo (Marca/Modelo)</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Ganancia Est.</th>
                    <th>Fecha Compra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $fila["id_telefono"]; ?></td>
                            <td><?php echo $fila["marca"] . " " . $fila["modelo"]; ?></td>
                            <td style="color: #ff6b6b; font-weight: bold;">
                                $<?php echo number_format($fila["precio_costo"], 2); ?>
                            </td>
                            <td style="color: var(--texto-blanco); font-weight: bold;">
                                $<?php echo number_format($fila["precio_venta"], 2); ?>
                            </td>
                            <td style="color: #00f5d4; font-weight: bold;">
                                $<?php echo number_format($fila["ganancia_estimada"], 2); ?>
                            </td>
                            <td><?php echo $fila["fecha_compra"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_precio.php?id=<?php echo $fila['id_telefono']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_precio.php?id=<?php echo $fila['id_telefono']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar este registro de costo?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; color:var(--texto-gris); padding:20px;'>No hay registros de costos de adquisición</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=precio" class="btn-agregar opcion-menu">Registrar Costo de Stock</a>
    </div>
</div>