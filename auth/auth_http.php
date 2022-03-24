<?php

// Ejemplo de Autenticacion via HTTP
$user = array_key_exists('PHP_AUTH_USER', $_SERVER) ? $_SERVER['PHP_AUTH_USER'] : '';
$pwd = array_key_exists('PHP_AUTH_PW', $_SERVER) ? $_SERVER['PHP_AUTH_PW'] : '';

//Validar si esta autenticado
if ($user !== 'lorenzo' || $pwd !== '1234') {
    $autenticated = false;
    die("Usuario o clave incorrecta \n");
}
