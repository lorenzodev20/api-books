<?php

// Para generar el hash para autenticarse usando el metodo HMAC
$time = time();

echo "Time: $time".PHP_EOL."Hash: ".sha1($argv[1].$time.'Sh!! No se lo cuentes a nadie!').PHP_EOL;