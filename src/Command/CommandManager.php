<?php

    namespace Eskirex\Component\Console\Command;

    class CommandManager
    {
        public static $commands;

        public static $callbacks;


        public static function setCommand($command, array $data)
        {
            self::$commands[$command] = $data;
        }


        public static function setCallback($command)
        {
            self::$callbacks[get_class($command)] = $command;
        }


        public static function getCommand($get = false)
        {
            if (false !== $get) {
                if (isset(self::$commands[$get])) {
                    return self::$commands[$get];
                }

                return null;
            }

            return self::$commands;
        }


        public static function getCommands()
        {
            return self::getCommand() ?? [];
        }


        public static function getCallback($get = false)
        {
            if (false !== $get) {
                if (isset(self::$callbacks[$get])) {
                    return self::$callbacks[$get];
                }

                return null;
            }

            return self::$callbacks;
        }


        public static function getCallbacks()
        {
            return self::getCallback() ?? [];
        }
    }