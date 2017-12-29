<?php

namespace Eskirex\Component\Console;

class AddCommand extends Console
{
    protected $name;

    protected $description;

    protected $help;

    protected $callback;

    protected $command;


    public function add()
    {
        static::$commands[$this->name] = [
            'description' => $this->description,
            'help'        => $this->help,
            'callback'    => $this->callback
        ];
    }


    public function name($name)
    {
        $this->name = $name;

        return $this;
    }


    public function description($description)
    {
        $this->description = $description;

        return $this;
    }


    public function help($help)
    {
        $this->help = $help;

        return $this;
    }


    public function callback($callback)
    {
        $this->callback = $callback;

        return $this;
    }
}