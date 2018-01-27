<?php

    namespace Eskirex\Component\Console\Output\Formatters;

    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Exceptions\InvalidArgumentException;
    use Eskirex\Component\Console\Output\Ansi;
    use Eskirex\Component\Console\Output\Translator;
    use Eskirex\Component\Console\Output\Writer;
    use Eskirex\Component\Console\Input\InputManager;

    class Question
    {
        private static $output;


        public static function formatter(string $question, array $options, string $defaultKey)
        {
            if (count($options) < 2) {
                throw new InvalidArgumentException('Options keys two or more');
            }

            $question = self::clean($question);

            $options = self::clean($options);

            $defaultKey = self::clean($defaultKey);


            if (!isset($options[$defaultKey])) {
                throw new InvalidArgumentException('Default key not in options');
            }

            if (InputManager::getOption(Configuration::SILENT_OPTION)) {
                return $defaultKey;
            }

            $keyMaxWidth = max(array_map('mb_strlen', array_keys($options)));
            $valueMaxWidth = max(array_map('mb_strlen', array_values($options)));

            $output = "";
            $output .= Title::formatter("{$question} <iblack>[%word.default% : {$defaultKey}<iblack>]");
            $output .= "\n <iblack>{ <reset>";

            foreach ($options as $key => $option) {
                $extraSpaceForKey = str_repeat(" ", $keyMaxWidth - mb_strlen($key));
                $extraSpaceForValue = str_repeat(" ", $valueMaxWidth - mb_strlen($option));

                $output .= "\n   <white>{$key}<reset><iblack>{$extraSpaceForKey} : {$option}<reset>";

                if ($defaultKey !== false && $key === $defaultKey) {
                    $output .= "<iblack>{$extraSpaceForValue} [%word.default%]<reset>";
                }
            }

            $output .= "\n <iblack>}<reset>";
            Writer::write($output);

            while (true) {
                Writer::write("\n\n<bg_igreen><black> ► <reset> ");

                if (InputManager::getOption(Configuration::NO_QUESTION_OPTION)) {
                    $response = $defaultKey;
                    echo "\n";
                } else {
                    $handle = fopen("php://stdin", "r");
                    $line = fgets($handle);
                    $response = trim($line);

                    if (empty($response)) {
                        $response = $defaultKey;
                    }

                    fclose($handle);
                }


                if (!array_key_exists($response, $options)) {
                    echo Writer::write("\n<black><bg_ired><b> %error% <reset> : <iblack>%question.error%<reset>\n");
                } else {
                    echo Writer::write("\n<black><bg_igreen><b> %successfull% <reset> : <iblack>%question.successfull% $response<reset>\n");
                    break;
                }
            }

            return $response;
        }


        public static function clean($input)
        {
            $input = json_encode($input);
            $input = Translator::replace($input);
            $input = Ansi::clean($input);
            $input = json_decode($input, true);

            return $input;
        }
    }