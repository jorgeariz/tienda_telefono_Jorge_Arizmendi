<?php 
if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT id_color, nombre_color FROM color WHERE activo = 1";
$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Colores</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID del color</th>
                    <th>Nombre del color</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $fila["id_color"]; ?></td>
                            <td><?php echo $fila["nombre_color"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_color.php?id=<?php echo $fila['id_color']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_color.php?id=<?php echo $fila['id_color']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar este color?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; color:var(--texto-gris); padding:20px;'>No hay colores registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=colores" class="btn-agregar opcion-menu">Agregar Color</a>
    </div>
</div>