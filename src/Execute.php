<?php

namespace Eskirex\Component\Console;

class Execute extends Console
{
    public function __construct()
    {
        if (isset($GLOBALS['argv'])) {
            static::$segments = array_splice($GLOBALS['argv'], 1, count($GLOBALS['argv']));
        }

        if (empty($this->segments())) {

            exit;
        }
        if (array_key_exists($this->segments(0), $this->commands())) {
            print_r($this->commands($this->segments(0)));
            print_r($this->commands());
        }

        $data = [];
        foreach ($this->commands() as $command => $config) {
            $data[] = [
                'command'     => $command,
                'description' => $config['description'],
                'callback'    => $config['callback']
            ];
        }

        $renderer = new Table($data);
        $renderer->showHeaders(true);
        $renderer->render();
        //print_r($this->segments());
    }


    public function run()
    {

    }
}