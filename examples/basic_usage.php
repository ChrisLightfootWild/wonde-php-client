<?php

require __DIR__ . '/../vendor/autoload.php';

$token = getenv('WONDE_API_TOKEN') ?: die('You must provide WONDE_API_TOKEN');

$client = new Wonde\Client($token);

dump(
    $schools = $client->schools->all(),
);

$schools->rewind();
$school = $schools->current();

dump(
    $response = $client->school($school)->counts->getRaw(parameters: ['include' => 'classes,employees']),
    (string) $response->getBody(),
    $client->school($school)->counts->get(
        includes: new \Wonde\Resources\QueryParameters\Includes('classes', 'employees', 'students'),
    ),
);

dump(
    $client->attendanceCodes->get(),
    // Custom attendance codes, or just the default if none have been set.
    $client->school($school)->attendanceCodes->get(),
);
