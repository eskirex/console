<?php

namespace Eskirex\Component\Console;

class Console
{
    static $commands;

    static $segments;


    public function add($name)
    {
        return new Add($name);
    }


    public function run()
    {
        return new Execute();
    }


    protected function commands($key = null)
    {
        if ($key !== null) {
            if (isset(static::$commands[$key])) {
                return static::$commands[$key];
            }
        }

        return static::$commands;
    }


    protected function segments($key = null)
    {
        if ($key !== null) {
            if (isset(static::$segments[$key])) {
                return static::$segments[0];
            }
        }

        return static::$segments;
    }


}