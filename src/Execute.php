<?php

namespace Eskirex\Component\Console;

use Eskirex\Component\Console\Resources\Config;

class Execute extends Console
{
    public function __construct()
    {
        if (empty($this->segments())) {
            return;
        }
        $command = $this->segments(0);
        $content = $this->getContent($command);
        $this->write($content);
    }


    public function getContent($command)
    {
        if (strpos($command, ':')) {
            $parsedSegment = explode(':', $this->segments(0));
            $command = $parsedSegment[0];
            $method = $parsedSegment[1];
        }

        if (!array_key_exists($command, $this->commands())) {
            return null;
        }

        $commandData = $this->commands($command);
        $callback = $commandData['callback'];

        if (is_callable($callback)) {
            return $callback(new Console());
        }

        if (is_string($callback)) {
            if (class_exists($callback)) {
                $class = new $callback;

                if (!method_exists($class, $method ?? null)) {
                    $method = Config::DEFAULT_METHOD;
                }

                return $class->{$method}();
            }

            return $callback;
        }
    }


    public function run($command)
    {
        $description = $this->commands($command)['description'];
        $help = $this->commands($command)['help'];
        $callback = $this->commands($command)['callback'];

        if (is_callable($callback)) {
            return $callback(new Console());
        }

        if (is_string($callback)) {

            if (class_exists($parsedSegment[0])) {
                $controller = new $callback;
                $method = $parsedSegment[1];

                if (method_exists($controller, $method)) {
                    return $controller->{$method}();
                }

                return $controller->{Config::DEFAULT_METHOD}();
            }

            return $callback;
        }
    }


    public function write($data)
    {
        echo $data;
    }
}