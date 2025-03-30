<?php

$url = 'http://api';

try {
    $response = file_get_contents($url);

    echo $response;
} catch (Exception $e) {
    die('Erro');
}
