<?php

//Autenticación vía HMAC (Ejemplo)

/**
 * Generar primeramnete el hash con el archivo: generate_hash.php
 */

if (!array_key_exists('HTTP_X_HASH', $_SERVER) || !array_key_exists('HTTP_X_TIMESTAMP', $_SERVER) || !array_key_exists('HTTP_X_UID', $_SERVER)) {
    header('Status-Code: 403');
    echo json_encode(
        [
            'error' => "No autorizado",
        ]
    );
    $autenticated = false;
    die;
}

list($hash, $uid, $timestamp) = [$_SERVER['HTTP_X_HASH'], $_SERVER['HTTP_X_UID'], $_SERVER['HTTP_X_TIMESTAMP']];
$secret = 'Sh!! No se lo cuentes a nadie!';
$newHash = sha1($uid . $timestamp . $secret);

if ($newHash !== $hash) {
    header('Status-Code: 403');
    echo json_encode(
        [
            'error' => "No autorizado. Hash esperado: $newHash, hash recibido: $hash",
        ]
    );
    $autenticated = false;
    die;
}