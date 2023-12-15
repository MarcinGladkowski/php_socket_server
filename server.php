<?php

error_reporting(E_ALL);

$address = '127.0.0.1';
$port = 8888;

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
$bind = socket_bind($socket, $address, $port);

if ($bind === false) {
    echo "Socket not bind \n";
}


echo "Socket server started \n";
socket_listen($socket,1);

while (true) {
    $result = socket_accept($socket);

    if ($result === false) {
        $socketErrorHandler($socket);
    }

    if ($result) {
        echo "Someone connected ? \n";

       // socket_write($socket, 'data', strlen('data'));
        $msg = "Ping !";
        $len = strlen($msg);

        //socket_send($result, $msg, $len, MSG_EOR);

        $request = 'GET / HTTP/1.1' . "\r\n" .
            'Host: example.com' . "\r\n\r\n";
        $sendResult = socket_write($result, $request);

        if (!$sendResult) {
            echo "Problem with return data \n";
        }

        if ($sendResult) {
            echo "Send with result {$sendResult}\n";
        }

        socket_close($result);
    }
    sleep(1);
}






