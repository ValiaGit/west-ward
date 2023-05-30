<?php


namespace App\Integrations\Helpers;

use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class GISLogger
{

    /**
     * @var Logger
     */
    private $instance;

    public function __construct()
    {

        $monolog = Log::getMonolog();

        $monolog->pushHandler(new StreamHandler(storage_path('logs/warn.log'), Logger::WARNING));
        $monolog->pushHandler(new StreamHandler(storage_path('logs/error.log'), Logger::ERROR));
        $monolog->pushHandler(new StreamHandler(storage_path('logs/info.log'), Logger::INFO));
        $monolog->pushHandler(new StreamHandler(storage_path('logs/debug.log'), Logger::DEBUG));

        $this->instance = $monolog;
    }


    public function debug($message,$context = [])
    {
       if(gettype($context) !=='array') {
           $context = [$context];
       }
        $this->instance->debug($message,$context);
    }

    public function info($message,$context = [])
    {
        if(gettype($context) !=='array') {
            $context = [$context];
        }
        $this->instance->info($message,$context);
    }

    public function error($message,$context = [])
    {
        if(gettype($context) !=='array') {
            $context = [$context];
        }
        $this->instance->error($message,$context);
    }

    public function warn($message,$context = [])
    {
        if(gettype($context) !=='array') {
            $context = [$context];
        }
        $this->instance->warn($message,$context);
    }


}