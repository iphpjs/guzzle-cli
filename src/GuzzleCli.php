<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2019-04-08
 * Time: 19:20
 */

namespace GuzzleCli;

class GuzzleCli
{
    const SOURCE_VERSION = '0.1-dev+source';

    public static function getVersion()
    {
        return self::SOURCE_VERSION;
    }
}