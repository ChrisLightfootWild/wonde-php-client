<?php

require __DIR__ . '/../vendor/autoload.php';

use Wonde\Client;
use Wonde\Resources\QueryParameters\Includes;

$token = getenv('WONDE_API_TOKEN') ?: die('You must provide WONDE_API_TOKEN');

$client = new Client($token);

dump(
    $schools = $client->schools->approved(),
);

$schools->rewind();
$school = $schools->current();

dump(
    $response = $client->school($school)->counts->getRaw(parameters: ['include' => 'classes,employees']),
    (string) $response->getBody(),
    $client->school($school)->counts->get(
        includes: new Includes('classes', 'employees', 'students'),
    ),
);

dump(
    $client->attendanceCodes->get(),
    // Custom attendance codes, or just the default if none have been set.
    $client->school($school)->attendanceCodes->get(),
);
