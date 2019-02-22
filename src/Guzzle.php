<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2018/12/20
 * Time: 11:28
 */

namespace GuzzleCli;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Guzzle
 *
 * 如果需要记录http原始请求，建议使用new Guzzle()方式，
 * 如果不需要记录http原始请求，建议使用Guzzle::getInstance()获取实例，以节约内存。
 *
 * @author suse 17246503142@163.com
 * @package App\Util
 */
class Guzzle extends Client
{
    const CONFIG = [
        'verify'   => false,
        'time_out' => 3,
        'headers'  => [],
    ];

    private $options = [];

    private $request;

    private static $instance;

    public function __construct()
    {
        $config = self::CONFIG;

        $config['proxy'] = '127.0.0.1:8080';
        true or $config['handler'] = function () {
            $handler = null;
            if (function_exists('curl_multi_exec') && function_exists('curl_exec')) {
                //                $handler = Proxy::wrapSync();
                //                dd('a');
            }
        };

        parent::__construct($config);
    }

    private function clone()
    {
    }

    public static function getInstance()
    {
        self::$instance instanceof self or self::$instance = new self;

        return self::$instance;
    }

    public function send(RequestInterface $request, array $options = [])
    {
        $this->request = $request;
        $this->options = $options;

        return parent::send($request, $options);
    }

    public function __call($method, $args)
    {
        $uri           = $args[0];
        $this->request = new Request($method, $uri);
        $this->options = $args[1] ?? [];

        return parent::__call($method, $args);
    }

    public function getRawRequest(): string
    {
        $request = $this->request or die('未发送请求，无法获取原始请求');
        assert($request instanceof RequestInterface);

        $method  = $request->getMethod();
        $target  = $request->getRequestTarget();
        $version = $request->getProtocolVersion();
        $line    = sprintf('%s %s HTTP/%s', $method, $target, $version);

        $userAgentFlag = true;
        foreach (self::CONFIG['headers'] as $key => $value) {
            $request = $request->withHeader($key, $value);
            // Add the User-Agent header if one was not already set.
            if (strtolower($key) === 'user-agent') {
                $userAgentFlag = false;
            }
        }
        $userAgentFlag && $request = $request->withHeader('User-Agent', \GuzzleHttp\default_user_agent());
        if (isset($this->options['json'])) {
            $contentType = 'application/json';
            $body        = \GuzzleHttp\json_encode($this->options['json']);
        } elseif (isset($this->options['form_params'])) {
            $contentType = 'application/x-www-form-urlencoded';
            $body        = http_build_query($this->options['form_params'], '', '&');
        } else {
            $body = $request->getBody();
            if ($body instanceof MultipartStream) {
                $contentType = 'multipart/form-data; boundary=' . $body->getBoundary();
            }
        }

        isset($contentType) && $request = $request->withHeader('Content-Type', $contentType);
        isset($contentType) && $request = $request->withHeader('Content-Length', strlen($body));
        $request->hasHeader('Connection') or $request = $request->withHeader('Connection', 'close');

        return self::getRawHttp($line, $request, $body);
    }

    public function getRawResponse(ResponseInterface $response): string
    {
        $code    = $response->getStatusCode();
        $phrase  = $response->getReasonPhrase();
        $version = $response->getProtocolVersion();
        $line    = sprintf('HTTP/%s %d %s', $version, $code, $phrase);
        $body    = (string)$response->getBody();

        return self::getRawHttp($line, $response, $body);
    }

    private static function getRawHttp(string $line, MessageInterface $message, string $body = ''): string
    {
        $header      = '';
        $headerNames = array_keys($message->getHeaders());
        if (($key = array_search('Host', $headerNames)) !== false) {
            unset($headerNames[$key]);
            array_unshift($headerNames, 'Host');
        }
        foreach ($headerNames as $value) {
            $header .= $value . ': ' . $message->getHeaderLine($value) . "\r\n";
        }

        $rawHttp = '';
        $rawHttp .= $line;
        $rawHttp .= "\r\n";
        $rawHttp .= $header;
        $rawHttp .= "\r\n";
        $rawHttp .= $body;

        return $rawHttp;
    }
}
