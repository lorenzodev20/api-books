<?php
/**
 * Servidor de Autenticación via access token
 * Este es el archivo que se usará para generar el token y que estará en otro servidor
 * debemos ejecutarlo para generar el token
 */

$method = strtoupper( $_SERVER['REQUEST_METHOD'] );

// $token = "5d0937455b6744.68357201";
$token = "25940634623c0eb44fdb67adfdc41609f07f9af6";
// $token = sha1('Esto es un secreto!');

if ( $method === 'POST' ) {
    if ( !array_key_exists( 'HTTP_X_CLIENT_ID', $_SERVER ) || !array_key_exists( 'HTTP_X_SECRET', $_SERVER ) ) {
        http_response_code( 400 );

        die( 'Faltan parametros' );
    }

    $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
    $secret = $_SERVER['HTTP_X_SECRET'];

    if ( $clientId !== '1' || $secret !== 'SuperSecreto!' ) {
        http_response_code( 403 );

        die ( "No autorizado");
    }

    echo "$token";
} elseif ( $method === 'GET' ) {
    if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
        http_response_code( 400 );

        die ( 'Faltan parametros' );
    }

    if ( $_SERVER['HTTP_X_TOKEN'] == $token ) {
        echo 'true';
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}

// Solicitar el token de autenticacion ingresando un usuario y una contraseña
// curl http://localhost:8001 -X 'POST' -H 'X-Client-Id:1' -H 'X-Secret: SuperSecreto!'

// Conectarse al servidor de recursos usando el token generado por el servidor de autenticación
// curl http://localhost:8000/books -H 'X-Token: 25940634623c0eb44fdb67adfdc41609f07f9af6'