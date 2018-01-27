<?php

    namespace Eskirex\Component\Console;

    use Eskirex\Component\Console\Command\CommandManager;
    use Eskirex\Component\Console\Input\Traits\InputParse;
    use Eskirex\Component\Console\Input\InputManager;

    class Input
    {
        use InputParse;

        private $commandData;


        public function __construct()
        {
            if (empty(InputManager::getSegments())) {
                $this->parse();
                $this->save();
            }
            
            $this->commandData = CommandManager::getCommand(InputManager::getCommand());
        }


        public function getArgument($alias)
        {
            if (null === $this->commandData['arguments']) {
                return null;
            }

            $argumentsData = $this->commandData['arguments'];
            $index = array_search($alias, array_column($argumentsData, 'alias'));

            if (false === $index) {
                return null;
            }

            return InputManager::getArgument($index);
        }


        public function getOption($alias)
        {
            if (null === $this->commandData['options'] || !isset($this->commandData['options'][$alias])) {
                return null;
            }

            $optionData = $this->commandData['options'][$alias];

            if (is_array($optionData['options'])) {
                foreach ($optionData['options'] as $option) {
                    if (array_key_exists($option, InputResource::getOptions())) {
                        return InputResource::getOption($option);
                        continue;
                    }
                }
            } else if (is_string($optionData['options'])) {
                return InputResource::getOption($optionData['options']);
            }

            return null;
        }


        public function getCommand()
        {
            return InputManager::getCommand();
        }
    }