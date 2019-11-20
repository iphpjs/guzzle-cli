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
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\Console\Input\InputInterface;
use function GuzzleHttp\Psr7\parse_request;
use function GuzzleHttp\Psr7\str;

class Cli
{
    private $fileFullPath;

    public function __construct($fileFullPath)
    {
        $this->fileFullPath = $fileFullPath;
    }

    public function readAsString()
    {
        file_exists($this->fileFullPath) or die(sprintf('指定的文件:%s不存在！' . PHP_EOL, $this->fileFullPath));

        return file_get_contents($this->fileFullPath);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(InputInterface $input)
    {
        $config = [];
        if ($input->hasParameterOption('--proxy')) {
            $config['proxy'] = $input->getParameterOption('--proxy');
        }

        $guzzle = Guzzle::instance($config);
        $guzzle->send(parse_request($this->readAsString()));

        if ($input->hasParameterOption('-i')) {
            echo $guzzle->getRawRequest();
            echo PHP_EOL;
        }
        echo $guzzle->getRawResponse();
    }
}