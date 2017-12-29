<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 29.12.2017
 * Time: 12:20
 */

namespace Eskirex\Component\Console;

use Symfony\Component\Console\Input\ArgvInput;

class Command
{
    private $name;

    private $description;

    private $help;
    static $bag;


    public function __construct()
    {
        $this->configure();
        static::$bag = 'asd';
    }


    protected function configure()
    {

    }


    protected function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }


    protected function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }


    protected function setHelp(string $help)
    {
        $this->help = $help;

        return $this;
    }


    protected function getName()
    {
        return $this->name;
    }


    protected function getDescription()
    {
        return $this->description;
    }


    protected function getHelp()
    {
        return $this->help;
    }
}
