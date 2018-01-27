<?php

    namespace Eskirex\Component\Console\Command\Traits;

    use Eskirex\Component\Console\Output\Translator;

    trait CommandConfigure
    {
        protected function setName($name)
        {
            $this->name = $name;

            if (false !== strpos($name, ':')) {
                $this->namespace = explode(':', $this->name, 2)[0];
            }


            return $this;
        }


        protected function setDescription($description)
        {
            $this->description = Translator::replace($description);

            return $this;
        }


        protected function setHelp(string $help)
        {
            $this->help = Translator::replace($help);

            return $this;
        }


        protected function setVersion($version)
        {
            $this->version = $version;

            return $this;
        }


        protected function setArgument($alias, $description)
        {
            $this->arguments[$alias] = [
                'alias'       => $alias,
                'description' => Translator::replace($description),
            ];

            return $this;
        }


        protected function setOption(string $name, $shortcut, $description)
        {
            $this->options[$name] = [
                'name'        => $name,
                'shortcut'    => strpos($shortcut, '|') ? explode('|', $shortcut) : $shortcut,
                'description' => Translator::replace($description),
            ];

            return $this;
        }
    }