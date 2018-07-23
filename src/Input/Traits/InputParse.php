<?php

    namespace Eskirex\Component\Console\Input\Traits;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Input\InputManager;

    trait InputParse
    {
        private $segments;

        private $command;

        private $arguments;

        private $options;


        private function parse()
        {
            $this->segments = $this->getSegments();
            $ignored = [];

            foreach ($this->segments as $key => $segment) {
                // Check for ignored key
                if (!in_array($segment, $ignored)) {
                    // Check for its option
                    if (false !== strpos($segment, '-')) {

                        //if (array_key_exists($segment, InputManager::$rules)) {
                        //    InputManager::$rules[$segment] = true;
                        //} else {
                        $nextSegment = $this->segments[$key + 1] ?? false;

                        if (!$nextSegment || false !== strpos($nextSegment, '-')) {
                            $option = true;
                        } else {
                            $option = $nextSegment === 'false' || $nextSegment === 'true' || $nextSegment === 'null'
                                ? filter_var($nextSegment, FILTER_VALIDATE_BOOLEAN)
                                : (string) $nextSegment;

                            $ignored[] = $nextSegment;
                        }

                        $this->options[$segment] = $option;
                        //}
                    } else {
                        if (!$this->command) {
                            $this->command = $segment;
                        } else {
                            $this->arguments[] = $segment;
                        }
                    }
                }
            }

            if (!$this->command) {
                $this->command = Configuration::DEFAULT_COMMAND;
            }
        }


        private function save()
        {
            InputManager::setSegments($this->segments);
            InputManager::setCommand($this->command);
            InputManager::setArguments($this->arguments);
            InputManager::setOptions($this->options);
        }


        private function getSegments()
        {
            if (!isset($_SERVER['argv'])) {
                exit('no argv');
            }

            $segments = $_SERVER['argv'];

            if (isset($segments[0]) && ($segments[0] == $_SERVER['PHP_SELF'] || $segments[0] == $_SERVER['SCRIPT_FILENAME'])) {
                array_shift($segments);
            }

            return $segments;
        }
    }