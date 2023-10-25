<?php

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Wonde\Client;
use Wonde\Resources\QueryParameters\Includes;

$logger = new Logger('wonde-example', handlers: [
    $stream = new StreamHandler(\STDOUT),
]);

$token = getenv('WONDE_API_TOKEN');

if (! $token) {
    $logger->warning('You must provide WONDE_API_TOKEN', [
        'example' => 'WONDE_API_TOKEN=<YOU_WONDE_TOKEN_GOES_HERE> php examples/basic_usage.php',
    ]);

    exit(1);
}

$client = new Client($token, logger: $logger);

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

dump(
    $client->meta->school($school->id),
    $client->meta->accessControlList($school->id),
    $client->meta->permissions($school->id),
);
