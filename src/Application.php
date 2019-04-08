<?php
/**
 * Created by PhpStorm.
 * User: suse
 * Date: 2019-04-08
 * Time: 18:53
 */

namespace GuzzleCli;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    /**
     * @var guzzle-cli
     */
    protected $guzzle_cli;

    /**
     * @var IOInterface
     */
    protected $io;

    private static $logo = <<<EOF
                      _                 _ _ 
                     | |               | (_)
   __ _ _   _ _______| | ___ ______ ___| |_ 
  / _` | | | |_  /_  / |/ _ \______/ __| | |
 | (_| | |_| |/ / / /| |  __/     | (__| | |
  \__, |\__,_/___/___|_|\___|      \___|_|_|
   __/ |                                    
  |___/                                     

EOF;


    private $hasPluginCommands = false;

    private $disablePluginsByDefault = false;

    public function __construct()
    {
        //        $this->io = new NullIO();

        parent::__construct('guzzle-cli', GuzzleCli::getVersion());
    }

    /**
     * {@inheritDoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        if (null === $output) {
            $output = Factory::createOutput();
        }

        return parent::run($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasParameterOption('-r')) {
            $file_full_path = $input->getParameterOption('-r');
            $config         = [];
            if ($input->hasParameterOption('--proxy')) {
                $config['proxy'] = $input->getParameterOption('--proxy');
            }

            (new Cli($file_full_path))->send($config);
        }
        if ($input->hasParameterOption('-v')) {
            echo self::$logo;
            echo PHP_EOL;
            echo 'version: ' . GuzzleCli::getVersion();
            echo PHP_EOL;
        } else {
            print_guzzle_cli_usage();
        }
    }
}