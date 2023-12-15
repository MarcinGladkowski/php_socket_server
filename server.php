<?php

error_reporting(E_ALL);

$socketErrorHandler = static function (\Socket $socket) {
    if (socket_last_error($socket)) {

        $error = socket_strerror(
            socket_last_error($socket)
        );

        echo sprintf("Error on socket %s \n", $error) ;
    }
};


$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_nonblock($socket);

if ($socket === false) {
    echo "Socket not created \n";
}

/**
 * socket_connect - we want to connect to some address
 * socket_bind - we're binding address to socket
 */
$bind = socket_bind($socket, '127.0.0.1', 8001);

if ($bind === false) {
    echo "Socket not bind \n";
}


echo "Socket server started \n";
socket_listen($socket,1);
sleep(1);

$result = socket_accept($socket);

if ($result === false) {
    $socketErrorHandler($socket);
}


