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
        <h2>Registros</h2>
        <a href="menu_mostrar.php?p=marcas">Marcas</a>
        <a href="menu_mostrar.php?p=colores">Colores</a>
        <a href="menu_mostrar.php?p=modelos">Modelos</a>
        <a href="menu_mostrar.php?p=telefono">Telefonos</a>
        <a href="menu_mostrar.php?p=precio">Precios</a>
        <a href="menu_mostrar.php?p=venta">Ventas</a>
        <a href="menu_mostrar.php?p=baja">Bajas</a>
        <a href="index.php">Regresar</a>
    </nav>

    <main class="contenido-principal">
        <?php
        $pagina = isset($_GET['p']) ? $_GET['p'] : 'inicio';

        switch ($pagina) {
            case 'marcas':
                include("mostrar/buscar_marca.php");
                break;
            case 'colores':
                include("mostrar/mostrar_color.php");
                break;
            case 'modelos':
                include("mostrar/mostrar_modelo.php");
                break;
            case 'telefono':
                include("mostrar/mostrar_telefono.php");
                break;
             case 'precio':
                include("mostrar/mostrar_precio.php");
                break;
            case 'venta':
                include("mostrar/mostrar_venta.php");
                break;
            case 'baja':
                include("mostrar/mostrar_baja.php");
                break;
            default:
                ?>
                <div class="main-card-panel bienvenida-panel">
                    <h1 class="titulo-bienvenida">Bienvenido</h1>
                    <p class="subtitulo-bienvenida">Selecciona una opción del menú lateral para comenzar a gestionar los registros del inventario.</p>
                    
                    <div class="contenedor-ilustracion">
                        <img src="img/telefono4.jpg" alt="Los mejores Celulares" class="img-bienvenida" style="max-width: 650px; border-radius: 25px;">
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
                if (panel && !this.classList.contains('btn-regresar') && this.getAttribute('href') !== 'index.php') {
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