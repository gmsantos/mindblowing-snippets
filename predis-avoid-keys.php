<?php

// Redis KEYS command can burn your Redis in production
// Redis SCAN is safer but is harder to use...
// Until now!

use Predis\Client;

$redisClient = new Predis\Client();

// Use this pattern to match Redis keys
$pattern = '*';

// KEYS way (avoid this)
$keys = $redisClient->keys($pattern);
$redisClient->del($keys);

// SCAN way (just do it)
$iterator = 0;
do {
    list($iterator, $keys) = Redis::scan($iterator, 'match', $pattern);
    if ($keys) {
        $redisClient->del($keys);
    }
} while ($iterator);
