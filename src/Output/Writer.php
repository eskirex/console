<?php

    namespace Eskirex\Component\Console\Output;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Input\InputManager;

    class Writer
    {
        public static function write(string $string)
        {
            if (InputManager::getOption(Configuration::SILENT_OPTION)) {
                return;
            }

            $rendered = self::render($string);

            echo $rendered;
        }


        public static function language(string $string)
        {
            if (preg_match_all(Configuration::REGEX_LANGUAGE, $string, $language)) {
                foreach ($language[0] as $key => $value) {
                    $replacer['find'][] = $value;
                }
                foreach ($language[1] as $value) {
                    $replacer['replace'][] = Translator::getValue($value);
                }
            }

            if (isset($replacer)) {
                $string = str_replace($replacer['find'], $replacer['replace'], $string);
            }

            return $string;
        }


        public static function render(string $string)
        {
            $string = Translator::replace($string);
            $string = Ansi::replace($string);
return $string;

            $string = str_replace($replacer['find'], $replacer['replace'], $string);

            return $string;

            if (preg_match_all(Configuration::REGEX_LANGUAGE, $string, $language)) {
                foreach ($language[0] as $key => $value) {
                    $replacer['find'][] = $value;
                }
                foreach ($language[1] as $value) {
                    $replacer['replace'][] = Translator::getValue($value);
                }
            }

            if (preg_match_all(Configuration::REGEX_ANSI, $string, $ansi)) {
                foreach ($ansi[0] as $key => $value) {
                    $replacer['find'][] = strpos($value, '/') ? str_replace('/', "\/", $value) : $value;
                }

                foreach ($ansi[1] as $key => $value) {
                    $replacer['replace'][] = !isset(Configuration::COMPILE_REPLACE[$ansi[0][$key]]) || !Ansi::isEnabled()
                        ? ''
                        : Configuration::COMPILE_REPLACE[$ansi[0][$key]];
                }
            }

            if (isset($replacer)) {
                $string = str_replace($replacer['find'], $replacer['replace'], $string);
            }

            return $string;
        }


        private function sasd()
        {

            $string .= "<reset>";
            $converted = str_replace(array_keys(self::$styles), self::isEnabled() ? array_values(self::$styles) : '', $string);

            if (!self::isEnabled()) {
                $converted = preg_replace(self::$colorRegex, '', $converted);
            } else {
                preg_match_all(self::$colorRegex, $converted, $match);

                $replace = [];

                foreach ($match[1] as $key => $item) {
                    $colors = [];
                    $ansi = "";

                    $item = str_replace(['\'', '"'], '', $item);
                    $item = preg_replace("/\s+/", " ", $item);
                    $item = trim($item);

                    if (false !== strpos($item, ' ')) {
                        foreach (explode(' ', $item) as $itemParsed) {
                            $itemParsed = explode('=', $itemParsed);
                            $colors[strtolower($itemParsed[0])] = strtolower($itemParsed[1]);
                        }
                    } else {
                        $itemParsed = explode('=', $item);
                        $colors[strtolower($itemParsed[0])] = strtolower($itemParsed[1]);
                    }

                    foreach ($colors as $type => $color) {
                        if ($type === 'fore') {
                            $ansi .= isset(self::$foregroundColors[$color]) ? self::$foregroundColors[$color] : '';
                        }
                        if ($type === 'back') {
                            $ansi .= isset(self::$backgroundColors[$color]) ? self::$backgroundColors[$color] : '';
                        }
                    }

                    $replace[$match[0][$key]] = $ansi;
                }

                foreach ($replace as $key => $value) {
                    $converted = str_replace($key, $value, $converted);
                }
            }

            return $converted;
        }
    }