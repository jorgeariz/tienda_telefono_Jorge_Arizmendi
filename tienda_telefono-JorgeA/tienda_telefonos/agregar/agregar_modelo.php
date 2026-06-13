<?php 
// Las consultas utilizan la conexión ya establecida en el archivo padre
$consulta_marcas = $conexion->query("SELECT id_marca, nombre FROM marca");
?>

<div class="main-card-panel">
    <h1>Agregar Modelo</h1>

    <div class="contenedor-form" style="max-width: 480px;"> <form action="insertar/insertar_modelo.php" method="POST">
            
            <div>
                <label for="nombre_modelo">Nombre del modelo:</label>
                <input type="text" name="nombre" id="nombre_modelo" placeholder="Ej. Galaxy S24, iPhone 15 Pro..." required>
            </div>

            <div>
                <label for="id_marca">Selecciona la Marca:</label>
                <select name="id_marca" id="id_marca" required>
                    <option value="">Seleccione una marca</option>
                    <?php 
                    while($m = $consulta_marcas->fetch_assoc()): 
                        $nombre_mostrar = isset($m['nombre_marca']) ? $m['nombre_marca'] : $m['nombre'];
                    ?>
                        <option value="<?php echo $m['id_marca']; ?>">
                            <?php echo $m['id_marca'] . " - " . $nombre_mostrar; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" name="enviar" class="btn-agregar">Guardar</button>
            </div>
            
        </form>
    </div>
</div>