<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2019-02-22
 * Time: 11:49
 */

namespace GuzzleCli;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class Cli
{
    private $file_full_path;

    public function __construct($file_full_path)
    {
        $this->file_full_path = $file_full_path;
    }

    public function read()
    {
        file_exists($this->file_full_path) or die(sprintf('指定的文件:%s不存在！' . PHP_EOL, $this->file_full_path));

        $lines  = [];
        $handle = fopen($this->file_full_path, 'r');
        while (!feof($handle)) {
            $lines[] = fgets($handle);
        }
        fclose($handle);

        return $lines;
    }

    public function parseRawHttp($lines)
    {
        $line        = $lines[0];
        $headerLines = array_slice($lines, 1, -2);

        $headers     = [];
        foreach ($headerLines as $item) {
            list($key, $value) = explode(':', $item, 2);
            $headers[$key] = trim($value);
        }

        list($method, $path, $version) = explode(' ', $line, 3);
        $host = $headers['Host'];
        $uri  = sprintf('http://%s%s', $host, $path);

        return [
            $method,
            $uri,
            $headers,
        ];
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        $lines = $this->read();
        list($method, $uri, $headers) = $this->parseRawHttp($lines);

        $guzzle  = new Guzzle();
        $request = new Request($method, $uri, $headers);
        try {
            $response = $guzzle->send($request);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        var_dump($guzzle->getRawRequest());
        var_dump($guzzle->getRawResponse($response));
    }
}