<?php

namespace Eskirex\Component\Console;

class Console
{
    static $commands;

    static $segments;


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
        $args = $_SERVER['argv'] ?? [];

        if (isset($args[0]) && $args[0] == $_SERVER['PHP_SELF']) {
            array_shift($args);
        }

        static::$segments = $args;

        if ($key !== null) {
            if (isset(static::$segments[$key])) {
                return static::$segments[$key];
            }

            return null;
        }

        return static::$segments;
    }


    protected function table($array, $showHeader = true)
    {
        if (!is_array($array)) {
            return null;
        }


        $table = new Table($array);

        $table->showHeaders($showHeader);

        return $table->render(true);
    }
}