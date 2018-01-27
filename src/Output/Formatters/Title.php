<?php

    namespace Eskirex\Component\Console\Output\Formatters;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Output\Ansi;
    use Eskirex\Component\Console\Output\Writer;

    class Title
    {
        private static $output;


        public static function formatter($string)
        {
            self::$output = '';
            $lineLen = mb_strlen(Ansi::clean(Writer::render($string), true), 'UTF-8');
            $line = str_repeat("─", $lineLen + 2);

            self::$output .= "\n<iblack>┌{$line}┐<reset>";
            self::$output .= "\n<iblack>│<reset> {$string}<reset> <iblack>│<reset>";
            self::$output .= "\n<iblack>└{$line}┘<reset>";

            return self::$output;
        }
    }