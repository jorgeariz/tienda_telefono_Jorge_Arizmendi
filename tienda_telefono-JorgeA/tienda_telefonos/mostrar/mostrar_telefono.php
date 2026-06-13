<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT t.id_telefono, 
               ma.nombre AS marca_nombre, 
               m.nombre AS modelo_nombre, 
               t.IMEI, 
               c.nombre_color, 
               t.precio_actual, 
               t.fecha_registro, 
               t.estado 
        FROM telefono t
        INNER JOIN modelo m ON t.id_modelo = m.id_modelo
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        INNER JOIN color c ON t.id_color = c.id_color
        WHERE t.activo = 1";

$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Teléfonos</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>IMEI</th>
                    <th>Color</th>
                    <th>Precio</th> <th>Fecha</th>
                    <th>Estado</th>
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
                            <td><?php echo $fila["marca_nombre"]; ?></td>
                            <td><?php echo $fila["modelo_nombre"]; ?></td>
                            <td><?php echo $fila["IMEI"]; ?></td>
                            <td><?php echo $fila["nombre_color"]; ?></td>
                            <td style="color: #00f5d4; font-weight: bold;">
                                <?php echo "$" . number_format($fila["precio_actual"], 2); ?>
                            </td>
                            <td><?php echo $fila["fecha_registro"]; ?></td>
                            <td><?php echo $fila["estado"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_telefono.php?id=<?php echo $fila['id_telefono']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_telefono.php?id=<?php echo $fila['id_telefono']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align:center; color:var(--texto-gris); padding:20px;'>No hay registros de teléfonos registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=telefono" class="btn-agregar opcion-menu">Agregar Teléfono</a>
    </div>
</div>