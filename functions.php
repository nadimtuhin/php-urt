<?php

function getUrtServerStatus($host, $port, $timeout){
    $socket = createUdpSocketConnection($host, $port, $timeout);
    $data = writeInSocketConnection($socket, "\377\377\377\377getstatus\n");

    $data = explode("\n", $data);

    $players = parsePlayers($data);
    $info = parseInfo($data);

    return compact('players', 'info');
}

function createUdpSocketConnection($host, $port, $timeout){
    $socket = socket_create (AF_INET, SOCK_DGRAM, getprotobyname('udp'));
    if(!socket_set_nonblock($socket)){
        throw new \Exception("Error! Unable to set nonblock on socket.");
    }
    $time = time();
    $error = "";

    // check if the connection timed out
    while (!@socket_connect ($socket, $host, $port )) {
        $err = socket_last_error ($socket);
        if ($err == 115 || $err == 114) {
            if ((time () - $time) >= $timeout)
            {
                socket_close ($socket);
                throw new \Exception("Error! Connection timed out.");
            }
            sleep(1);
            continue;
        }
    }

    if( strlen($error) != 0 ) {
        throw new \Exception("Error! {$error}");
    }

    return $socket;
}

function writeInSocketConnection($socket, $data){
    socket_write ($socket, $data);
    $read = [$socket];
    $out = "";
    $write = $except = null;

    while (socket_select ($read, $write, $except, 1)) {
        $out .= socket_read ($socket, 2048, PHP_BINARY_READ);
    }

    if($out == ""){
        throw new \Exception("Unable to connect to server");
    }

    return $out;
}



function parsePlayers($raw){
    $players = array_filter(array_slice($raw, 2));
    $players = array_map(function($player){
        $player = explode(' ',$player);

        return [
            'name' => $player[2],
            'ping' => $player[1],
            'score' => $player[0]
        ];
    }, $players);

    return $players;
}

function parseInfo($raw){
    //remove the first \
    $info = array_slice(explode('\\', $raw[1]), 1);
    $info = array_chunk($info, 2);

    $info = array_reduce($info, function($carry, $pair) {
        $carry[$pair[0]] = $pair[1];
        return $carry;
    }, []);

    return $info;
}
