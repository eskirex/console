<?php

    namespace Eskirex\Component\Console;

    use Eskirex\Component\Console\Command\CommandAbstract;

    class Command extends CommandAbstract
    {


//        use Configure;
//
//        private $namespace;
//
//        private $name;
//
//        private $description;
//
//        private $help;
//
//        private $arguments;
//
//        private $options;
//
//
//        public function __construct()
//        {
//            $this->configure();
//            $this->save();
//        }
//
//
//        public function configure()
//        {
//
//        }
//
//
//        private function save()
//        {
//            if (!$this->name) {
//                return false;
//            }
//
//            if (false !== strpos($this->name, ':')) {
//                $parseForNamespace = explode(':', $this->name);
//                $this->namespace = $parseForNamespace[0];
//            }
//
//            CommandResource::setCommand([
//                $this->name => [
//                    'namespace'   => $this->namespace,
//                    'name'        => $this->name,
//                    'description' => $this->description,
//                    'help'        => $this->help,
//                    'arguments'   => $this->arguments,
//                    'options'     => $this->options,
//                    'callback'    => get_called_class()
//                ]
//            ]);
//        }
    }
