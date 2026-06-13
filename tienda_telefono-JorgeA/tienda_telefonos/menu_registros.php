<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/estilo_mostrar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Mostrar Registros</title>
</head>
<body>
    <nav class="sidebar">
        <h2>Agregar Registros</h2>
        <a href="menu_registros.php?p=marcas">Agregar Marcas</a>
        <a href="menu_registros.php?p=colores">Agregar Colores</a>
        <a href="menu_registros.php?p=modelos">Agregar Modelos</a>
        <a href="menu_registros.php?p=telefono">Agregar Telefonos</a>
        <a href="menu_registros.php?p=precio">Agregar Precios</a>
        <a href="menu_registros.php?p=venta">Agregar Ventas</a>
        <a href="menu_registros.php?p=baja">Agregar Bajas</a>
        <a href="index.php" class="btn-regresar">Regresar</a>
    </nav>

    <main class="contenido-principal">
        <?php
        $pagina = isset($_GET['p']) ? $_GET['p'] : 'inicio';

        switch ($pagina) {
            case 'marcas':
                include("agregar/agregar_marca.php");
                break;
            case 'colores':
                include("agregar/agregar_color.php");
                break;
            case 'modelos':
                include("agregar/agregar_modelo.php");
                break;
            case 'telefono':
                include("agregar/agregar_telefono.php");
                break;
            case 'precio':
                include("agregar/agregar_precio.php");
                break;
            case 'venta':
                // Aquí se cargará el formulario modificado con Cliente y Tipo de Venta
                include("agregar/agregar_venta.php");
                break;
            case 'baja':
                include("agregar/agregar_baja.php");
                break;
            default:
                ?>
                <div class="main-card-panel bienvenida-panel">
                    <h1 class="titulo-bienvenida">Bienvenido</h1>
                    <p class="subtitulo-bienvenida">Selecciona una opción del menú lateral para comenzar a gestionar los registros del inventario.</p>
                    
                    <div class="contenedor-ilustracion">
                        <img src="img/telefono2.jpg" alt="Gestión de Teléfonos" class="img-bienvenida">
                    </div>
                </div>
                <?php
                break;
        }
        ?>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const links = document.querySelectorAll(".sidebar a");
        const panel = document.querySelector(".main-card-panel");

        links.forEach(link => {
            link.addEventListener("click", function(e) {
                // Si existe el panel y NO es el botón de regresar, ejecuta la animación suave
                if (panel && !this.classList.contains('btn-regresar')) {
                    e.preventDefault(); 
                    const targetUrl = this.href;

                    panel.classList.add("disappearing");

                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 280);
                }
            });
        });
    });
    </script>
</body>
</html>