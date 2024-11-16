<?php
// public/index.php

// Configuración de cabeceras para habilitar CORS y el tipo de contenido en JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configuración para los métodos HTTP
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization");

// Incluir el archivo de rutas donde se manejan las rutas de la API
require_once '../router.php';

?>
