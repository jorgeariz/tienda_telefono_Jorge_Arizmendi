<?php 

if (!isset($conexion)) {
    include('../conexion.php'); 
}

$sql = "SELECT id_marca, nombre FROM marca WHERE activo = 1;";
$resultado = $conexion->query($sql);
?>

<div class="main-card-panel">
    <h1 class="titulo-seccion">Listado de Marcas</h1>

    <div class="contenedor-tabla">
        <table class="tabla-estilizada">
            <thead>
                <tr>
                    <th>ID de la marca</th>
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
                            <td><?php echo $fila["id_marca"]; ?></td>
                            <td><?php echo $fila["nombre"]; ?></td>
                            <td>
                                <div class="bloque-acciones-lista">
                                    <a href="editar/editar_marca.php?id=<?php echo $fila['id_marca']; ?>" class="btn-lista-premium btn-editar-neo">Editar</a>
                                    
                                    <a href="eliminar/eliminar_marca.php?id=<?php echo $fila['id_marca']; ?>" 
                                       class="btn-lista-premium btn-eliminar-neo" 
                                       onclick="return confirm('¿Estás seguro de eliminar esta marca?');">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; color:var(--texto-gris); padding:20px;'>No hay marcas registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 10px;">
        <a href="menu_registros.php?p=marcas" class="btn-agregar opcion-menu">Agregar Marca</a>
    </div>
</div>