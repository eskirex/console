<?php

    namespace Eskirex\Component\Console\Output;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Console;
    use Eskirex\Component\Console\Exceptions\NotfoundException;

    class Translator
    {
        protected static $languageDir = Configuration::BASE . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR;

        protected static $default;

        protected static $fallback;


        public static function getValue(string $value)
        {
            if (!self::$default) {
                if (!file_exists(self::$languageDir . Console::getLanguage() . '.php')) {
                    throw new NotfoundException('Language file not found.');
                };

                self::$default = include(self::$languageDir . Console::getLanguage() . '.php');
            }

            if (!self::$fallback) {
                if (!file_exists(self::$languageDir . Configuration::FALLBACK_LANGUAGE . '.php')) {
                    throw new NotfoundException("Fallback language file not found.");
                };

                self::$fallback = include(self::$languageDir . Configuration::FALLBACK_LANGUAGE . '.php');
            }

            return self::$default[$value] ?? self::$fallback[$value] ?? 'undefined';
        }


        public static function replace(string $string)
        {
            $replacer = [
                'find'     => [],
                'replace' => []
            ];

            if (preg_match_all(Configuration::REGEX_LANGUAGE, $string, $language)) {
                foreach ($language[0] as $key => $value) {
                    $replacer['find'][] = $value;
                }
                foreach ($language[1] as $value) {
                    $replacer['replace'][] = self::getValue($value);
                }
            }
            
            $string = str_replace($replacer['find'], $replacer['replace'], $string);

            return $string;
        }
    }