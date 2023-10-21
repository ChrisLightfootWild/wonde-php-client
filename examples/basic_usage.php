<?php

require __DIR__ . '/../vendor/autoload.php';

$token = getenv('WONDE_API_TOKEN') ?: die('You must provide WONDE_API_TOKEN');

$client = new Wonde\Client($token);

dump($client->schools->all());
