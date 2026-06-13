<div class="main-card-panel">
    <h1>Agregar Color</h1>

    <div class="contenedor-form" style="max-width: 450px;">
        <form action="insertar/insertar_color.php" method="POST">
            
            <div>
                <label for="nombre_color">Nombre del color:</label>
                <input type="text" name="nombre_color" id="nombre_color" placeholder="Ej. Azul Zafiro, Negro Mate, Plata..." required>
            </div>

            <div class="acciones-form" style="margin-top: 10px;">
                <button type="submit" class="btn-agregar">Guardar</button>
            </div>
            
        </form>
    </div>
</div>