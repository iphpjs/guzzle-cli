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
use Throwable;

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
        $line       = $lines[0];
        $left_lines = array_slice($lines, 1);
        $headers    = [];
        $body       = '';
        $flag       = false;
        foreach ($left_lines as $item) {
            if ($flag) { // body
                $body .= $item;
                continue;
            }

            if(strpos($item, ':') !== false){
                list($key, $value) = explode(':', $item, 2);
                $headers[$key] = trim($value);
            }else{
                $flag = true;
            }


        }

        list($method, $path, $version) = explode(' ', $line, 3);
        preg_match('/HTTP\/(\d\.\d)/', $version, $matches);
        $version = $matches[1];
        $host    = $headers['Host'];
        $uri     = sprintf('http://%s%s', $host, $path);

        return [
            $method,
            $uri,
            $headers,
            $body,
            $version,
        ];
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        $lines = $this->read();

        $guzzle  = new Guzzle();
        $request = new Request(...$this->parseRawHttp($lines));
        try {
            $response = $guzzle->send($request);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        echo 'request: ' . PHP_EOL;
        echo $guzzle->getRawRequest() . PHP_EOL;
        echo 'response: ' . PHP_EOL;
        echo $guzzle->getRawResponse($response) . PHP_EOL;
    }
}