<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT m.id_modelo, m.nombre AS nombre_modelo, ma.nombre AS nombre_marca 
        FROM modelo m 
        INNER JOIN marca ma ON m.id_marca = ma.id_marca
        WHERE m.activo = 1";

$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Modelos</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID del modelo</th>
                    <th>Nombre del modelo</th>
                    <th>Nombre de la marca</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($resultado && $resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $fila["id_modelo"]; ?></td>
                            <td><?php echo $fila["nombre_modelo"]; ?></td>
                            <td><?php echo $fila["nombre_marca"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_modelo.php?id=<?php echo $fila['id_modelo']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_modelo.php?id=<?php echo $fila['id_modelo']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='4' style='text-align:center; color:var(--texto-gris); padding:20px;'>No hay modelos registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=modelos" class="btn-agregar opcion-menu">Agregar Modelo</a>
    </div>
</div>