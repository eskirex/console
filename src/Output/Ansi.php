<?php

    namespace Eskirex\Component\Console\Output;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Input\InputManager;

    class Ansi
    {
        private static $colorRegex       = "'<color(.*?)>'si";

        private static $foregroundColors = [
            'black'   => "\033[38;5;0m",
            'iblack'  => "\033[38;5;8m",
            'red'     => "\033[38;5;1m",
            'ired'    => "\033[38;5;9m",
            'green'   => "\033[38;5;2m",
            'igreen'  => "\033[38;5;10m",
            'yellow'  => "\033[38;5;3m",
            'iyellow' => "\033[38;5;11m",
            'blue'    => "\033[38;5;4m",
            'iblue'   => "\033[38;5;12m",
            'purple'  => "\033[38;5;5m",
            'ipurple' => "\033[38;5;13m",
            'cyan'    => "\033[38;5;6m",
            'icyan'   => "\033[38;5;14m",
            'white'   => "\033[38;5;7m",
            'iwhite'  => "\033[38;5;15m",
        ];

        private static $backgroundColors = [
            'black'   => "\033[48;5;0m",
            'iblack'  => "\033[48;5;8m",
            'red'     => "\033[48;5;1m",
            'ired'    => "\033[48;5;9m",
            'green'   => "\033[48;5;2m",
            'igreen'  => "\033[48;5;10m",
            'yellow'  => "\033[48;5;3m",
            'iyellow' => "\033[48;5;11m",
            'blue'    => "\033[48;5;4m",
            'iblue'   => "\033[48;5;12m",
            'purple'  => "\033[48;5;5m",
            'ipurple' => "\033[48;5;13m",
            'cyan'    => "\033[48;5;6m",
            'icyan'   => "\033[48;5;14m",
            'white'   => "\033[48;5;7m",
            'iwhite'  => "\033[48;5;15m",
        ];

        public static  $styles           = [
            '<normal>'    => "\033[0m",
            '<b>'         => "\033[1m",
            '<dim>'       => "\033[2m",
            '<i>'         => "\033[3m",
            '<u>'         => "\033[4m",
            '<blink>'     => "\033[5m",
            '<reverse>'   => "\033[7m",
            '<invisible>' => "\033[8m",
            '<reset>'     => "\033[0m",
        ];


        public static function isEnabled()
        {
            if (InputManager::getOption(Configuration::NO_ANSI_OPTION)) {
                return false;
            } else {
                return true;
            }
        }


        public static function replace(string $string)
        {
            $replacer = [
                'find'     => [],
                'replace' => []
            ];

            $string = '<reset>' . $string . '<reset>';

            if (preg_match_all(Configuration::REGEX_ANSI, $string, $ansi)) {
                foreach ($ansi[0] as $key => $value) {
                    $replacer['find'][] = strpos($value, '/') ? str_replace('/', "\/", $value) : $value;
                }

                foreach ($ansi[1] as $key => $value) {
                    $replacer['replace'][] = !isset(Configuration::COMPILE_REPLACE[$ansi[0][$key]]) || !self::isEnabled()
                        ? ''
                        : Configuration::COMPILE_REPLACE[$ansi[0][$key]];
                }
            }

            $string = str_replace($replacer['find'], $replacer['replace'], $string);

            return $string;
        }


        public static function compile(string $string, $clean = false)
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


        public static function clean(string $string, $unicodes = false)
        {
            $replaces = [
                '/\x1b(\[|\(|\))[;?0-9]*[0-9A-Za-z]/',
                '/\x1b(\[|\(|\))[;?0-9]*[0-9A-Za-z]/',
                '/[\x03|\x1a]/',
            ];

            return preg_replace($replaces, "", $string);
            $converted = $string;

            if ($unicodes) {
                $converted = preg_replace('/\x1b(\[|\(|\))[;?0-9]*[0-9A-Za-z]/', "", $converted);
                $converted = preg_replace('/[\x03|\x1a]/', "", $converted);
            }

            $converted = str_replace(array_keys(self::$styles), '', $converted);
            $converted = preg_replace(self::$colorRegex, '', $converted);

            return $converted;
        }
    }