<?php

    namespace Eskirex\Component\Console\Input;

    use Eskirex\Component\Console\Input\Traits\InputParse;

    class InputManager
    {
        protected static $command;

        protected static $segments;

        protected static $arguments;

        protected static $options;


        public static function setCommand($name)
        {
            self::$command = $name;
        }


        public static function setSegments($segments)
        {
            self::$segments = $segments;
        }


        public static function setArguments($arguments)
        {
            self::$arguments = $arguments;
        }


        public static function setOptions($options)
        {
            self::$options = $options;
        }


        public static function getCommand()
        {
            return self::$command;
        }


        public static function getSegment($get = false)
        {
            if (false !== $get) {
                if (isset(self::$segments[$get])) {
                    return self::$segments[$get];
                }

                return null;
            }

            return self::$segments;
        }


        public static function getSegments()
        {
            return self::$segments ?? [];
        }


        public static function getArgument($get = false)
        {
            if (false !== $get) {
                if (isset(self::$arguments[$get])) {
                    return self::$arguments[$get];
                }

                return null;
            }

            return self::$arguments;
        }


        public static function getArguments()
        {
            return self::$arguments ?? [];
        }


        public static function getOption($get = false)
        {
            if (false !== $get) {
                if (isset(self::$options[$get])) {
                    return self::$options[$get];
                }

                return null;
            }

            return self::$options;
        }


        public static function getOptions()
        {
            return self::$options ?? [];
        }
    }