<?php
/**
 * Este es el archivo de ejemplo.
 * Si deseas probar los otros metodos de autenticacion entonces se deben incluir en este archivo (HTTP, HMAC, TOKEN)
 */

$autenticated = true; // Bandera para saber si ya esta autenticado.

/* Requerimos el archivo de autenticacion. Solo uno a la vez */

// require_once 'auth/auth_http.php'; //Autenticacion HTTP
// require_once 'auth/auth_hmac.php'; //Autenticacion HMAC
//require_once 'auth/auth_token.php'; //Autenticacion Token

if ($autenticated) {
    // echo "\n Estas autenticado \n ";
    // Definimos los recursos disponibles
    $allowedResourceType = [
        'books',
        'authors',
        'genres',
    ];

    // Validamos que el recurso este disponible
    $resourceType = $_GET['resource_type'];

    if (!in_array($resourceType, $allowedResourceType)) {
        http_response_code(400);
        die;
    }

    // Defino los recursos
    $books = [
        1 => [
            'titulo' => 'Lo que el viento se llevo',
            'id_autor' => 2,
            'id_genero' => 2,
        ],
        2 => [
            'titulo' => 'La Iliada',
            'id_autor' => 1,
            'id_genero' => 1,
        ],
        3 => [
            'titulo' => 'La Odisea',
            'id_autor' => 1,
            'id_genero' => 1,
        ],
    ];

    // Se indica al cliente que lo que recibirá es un json
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

    // Levantamosel id dle recurso especifico
    $resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

    // Generamos la respuesta asumiendo que el pedido es correcto
    switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
        case 'GET':
            // Mostrar recursos
            if (empty($resourceId)) {
                echo json_encode($books);
            } else {
                if (array_key_exists($resourceId, $books)) {
                    echo json_encode($books[$resourceId]);
                }
            }
            break;
        case 'POST':
            // Generamos un nuevo recurso
            $json = file_get_contents('php://input');
            $books[] = json_decode($json, true);
            // echo array_keys($books)[count($books)-1];
            echo json_encode($books);
            break;
        case 'PUT':
            //validamos que el recurso buscado exista
            if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
                // Tomamos la entrada cruda
                $json = file_get_contents('php://input');
                // transformamos el json recibido a un nuevo elemento del arreglo
                $books[$resourceId] = json_decode($json, true);
                // Retornamos la coleccion modificada en formato json
                echo json_encode($books);
            }
            break;
        case 'DELETE':
            // validamos que el recurso exista
            if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
                // Eliminamos el recurso
                unset($books[$resourceId]);
                // Aquí verificamos que los cambios se han realizado
                echo json_encode($books);
            }
            break;
    }
}

// Inicio el servidor en la terminal 1
// php -S localhost:8000 server.php

// Terminal 2 ejecutar
// curl http://localhost:8000 -v // Viusaliza la comunicacion completa
// curl http://localhost:8000/\?resource_type\=books
// curl http://localhost:8000/\?resource_type\=books | jq
// curl http://localhost:8000/\?resource_type\=books -v > /dev/null // Ver informacion de los encabezados

// consulta
//$curl "http://localhost:8000?resource_type=books&resource_id=1"
// Método POST
//curl -X 'POST' http://localhost:8000/books -d '{"titulo":"Nuevo Libro","id_autor":1,"id_genero":2}'
// Método Put - el recurso 1 será reemplazado por el libro que estoy creando
// $ curl -X 'PUT' http://localhost:8000/books/1 -d '{"titulo": "Nuevo Libro", "id_autor": 1, "id_genero": 2}'
// curl -X 'DELETE' http://localhost:8000/books/1
