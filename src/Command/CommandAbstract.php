<?php

    namespace Eskirex\Component\Console\Command;

    use Eskirex\Component\Console\Command\Traits\CommandConfigure;

    abstract class CommandAbstract
    {
        use CommandConfigure;

        private $namespace;

        private $name;

        private $description;

        private $help;

        private $version;

        private $arguments;

        private $options;


        public function __construct()
        {
            $this->configure();
            $this->save();
        }


        protected function configure()
        {

        }


        private function save()
        {
            CommandManager::setCommand($this->name, [
                'namespace'   => $this->namespace,
                'name'        => $this->name,
                'description' => $this->description,
                'help'        => $this->help,
                'version'     => $this->version,
                'arguments'   => $this->arguments,
                'options'     => $this->options,
                'callback'    => get_called_class()
            ]);
        }
    }