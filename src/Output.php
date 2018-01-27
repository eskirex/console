<?php

    namespace Eskirex\Component\Console;

    use Eskirex\Component\Console\Output\Ansi;
    use Eskirex\Component\Console\Output\Writer;
    use Eskirex\Component\Console\Output\Formatters\Question;
    use Eskirex\Component\Console\Output\Formatters\Table;
    use Eskirex\Component\Console\Output\Formatters\Title;

    class Output
    {
        private $output;


        public function blank(int $count = 1)
        {
            $this->write(str_repeat("\n", $count));
        }


        public function write(string $string)
        {
            Writer::write($string);
        }


        public function writeIn(string $string)
        {
            $this->write("\n{$string}");
        }


        public function title(string $string)
        {
            $this->write(Title::formatter($string));
        }


        public function table($array, $showHeader = true)
        {
            if (!is_array($array)) {
                return null;
            }

            $table = new Table($array);

            $table->showHeaders($showHeader);

            $this->write($table->render(true));
        }


        public function ask(string $question, $options, $defaultKey)
        {
            return Question::formatter($question, $options, $defaultKey);
        }


        public function close()
        {
            exit();
        }
    }