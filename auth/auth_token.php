<?php

if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
	die;
}

// URL del servidor de autenticacion
// $url = 'https://'.$_SERVER['HTTP_HOST'].'/auth';
$url = 'http://localhost:8001';

$ch = curl_init( $url );

curl_setopt( $ch, CURLOPT_HTTPHEADER, [
	"X-Token: {$_SERVER['HTTP_X_TOKEN']}",
]);

curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$ret = curl_exec( $ch );

if ( curl_errno($ch) != 0 ) {
	die ( curl_error($ch) );
}

if ( $ret !== 'true' ) {
	http_response_code( 403 );
	die;
}
