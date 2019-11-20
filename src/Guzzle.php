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
use GuzzleHttp\TransferStats;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use function GuzzleHttp\Psr7\str;

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
        'verify'      => false,
        'http_errors' => false,
        'time_out'    => 1,
    ];

    private $rawRequest;

    private $rawResponse;

    private static $instance;

    public function __construct($config)
    {
        return parent::__construct($config + self::CONFIG);
    }

    private function clone()
    {
    }

    public static function instance($config)
    {
        self::$instance instanceof self or self::$instance = new self($config);

        return self::$instance;
    }

    public function send(RequestInterface $request, array $options = [])
    {
        return parent::send($request, $options + [
                'on_stats' => function (TransferStats $stats) {
                    $this->rawRequest  = str($stats->getRequest());
                    $this->rawResponse = str($stats->getResponse());
                },
            ]);
    }

    public function getRawRequest(): string
    {
        return $this->rawRequest;
    }

    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }
}
