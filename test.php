#!/usr/bin/env php
<?php

$method       = false;
$content_type = false;
$test         = false;
$auth         = true;

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

// auth test
if($auth){
    system('./guzzle-cli -r storage/data/http/auth/basic_auth_failed.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/auth/basic_auth_success.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/auth/bearer.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/auth/digest_auth_failed.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/auth/digest_auth_success.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;

    system('./guzzle-cli -r storage/data/http/auth/digest_auth_md5_success.http');
    echo PHP_EOL . str_repeat('-', 50) . PHP_EOL;
}