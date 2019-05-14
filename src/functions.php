<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2019-02-22
 * Time: 11:15
 */

namespace GuzzleCli;

function print_guzzle_cli_usage()
{
    echo <<<'EOF'
用法:
    guzzle-cli -r 1.http
选项:
    -r                  读取HTTP请求报文
    -i                  显示HTTP请求报文
    --secure            使用https协议
    --proxy <host:port> 使用指定代理
    -v                  显示版本


EOF;
}