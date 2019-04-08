<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2019-04-08
 * Time: 19:23
 */

namespace GuzzleCli;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

class Factory
{
    public static function createAdditionalStyles()
    {
        return [
            'highlight' => new OutputFormatterStyle('red'),
            'warning'   => new OutputFormatterStyle('black', 'yellow'),
        ];
    }

    /**
     * Creates a ConsoleOutput instance
     *
     * @return ConsoleOutput
     */
    public static function createOutput()
    {
        $styles    = self::createAdditionalStyles();
        $formatter = new OutputFormatter(false, $styles);

        return new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);
    }
}