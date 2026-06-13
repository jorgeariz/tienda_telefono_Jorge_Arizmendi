<?php
$conexion = new mysqli("localhost", "root", "", "tienda_telefono");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>