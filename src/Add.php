<?php

namespace Eskirex\Component\Console;

class Add extends Console
{
    protected $name;

    protected $description;

    protected $help;

    protected $callback;

    protected $command;


    public function __construct($name)
    {
        $this->name = $name;
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


    public function __destruct()
    {
        static::$commands[$this->name] = [
            'description' => $this->description,
            'help'        => $this->help,
            'callback'    => $this->callback
        ];
    }
}