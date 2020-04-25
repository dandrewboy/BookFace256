<?php
namespace App\Utility;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ServiceLogger implements ILoggerService
{
    private $logger = null;

    function getLogger()
    {
        if(self::$logger == null) 
        {
            self::$logger = new Logger('MyApp');
            $stream = new StreamHandler('storage/logs/myapp.log', Logger::DEBUG);
            $stream->setFormatter(new LineFormatter("%datetime% : %level_name% : %message% : %context%\n", "g:iA n/j/Y"));
            self::$logger->pushHandler($stream);
        }
        return self::$logger;
    }
    
    public function debug($message, $data=array())
    {
        self::getLogger()->debug($message, $data);
    }
    
    public function warning($message, $data=array())
    {
        self::getLogger()->warning($message, $data);
    }

    public function error($message, $data=array())
    {
        self::getLogger()->error($message, $data);
    }

    public function info($message, $data=array())
    {
        self::getLogger()->info($message, $data);
    }
}

