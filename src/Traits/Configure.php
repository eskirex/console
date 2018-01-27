<?php

    namespace Eskirex\Component\Console\Traits;

    trait Configure
    {
        protected function setName(string $name)
        {
            $this->name = $name;

            return $this;
        }


        protected function getName()
        {
            return $this->name;
        }


        protected function setDescription(string $description)
        {
            $this->description = $description;

            return $this;
        }


        protected function getDescription()
        {
            return $this->description;
        }


        protected function setHelp(string $help)
        {
            $this->help = $help;

            return $this;
        }


        protected function getHelp()
        {
            return $this->help;
        }


        protected function setArgument($alias, $description = false, $help = false, $require = false)
        {
            $this->arguments[$alias] = [
                'alias'       => $alias,
                'description' => $description,
                'help'        => $help,
                'require'     => $require,
            ];

            return $this;
        }


        protected function setOption($alias, $option, $description = false, $help = false, $require = false)
        {
            $this->options[$alias] = [
                'alias'       => $alias,
                'options'     => strpos($option, '|') ? explode('|', $option) : $option,
                'description' => $description,
                'help'        => $help,
                'require'     => $require,
            ];

            return $this;
        }
    }