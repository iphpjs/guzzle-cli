#!/usr/bin/env php
<?php

$method       = true;
$content_type = false;
$test         = false;

// method test
if ($method) {
    system('./guzzle-cli -r storage/data/http/method/delete.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/method/get.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/method/patch.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/method/post.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/method/put.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;
}

// content-type test
if ($content_type) {
    system('./guzzle-cli -r storage/data/http/content-type/application/json.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/content-type/application/json.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/content-type/multipart/form-data.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/content-type/text/plain.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/content-type/text/xml.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;
}

// test test
if ($test) {
    system('./guzzle-cli -r storage/data/http/test/chat_detail.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/test/config_init.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/test/hotel_detail.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;
}
