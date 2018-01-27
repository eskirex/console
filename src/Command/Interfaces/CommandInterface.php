<?php

    namespace Eskirex\Component\Console\Command\Interfaces;

    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Input;

    interface CommandInterface
    {
        function configure();


        public function execute(Input $input, Output $output);
    }