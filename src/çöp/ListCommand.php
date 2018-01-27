<?php

    namespace Eskirex\Component\Console\Commands;

    use Eskirex\Component\Console\Command;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Manage;
    use Eskirex\Component\Console\Input;
    use Eskirex\Component\Console\Text;

    class ListCommand extends Command
    {
        public function configure()
        {
            $this->setName('list');
        }


        public function execute(Input $input, Output $output)
        {
            exit;
            $commandData = CommandResource::getCommand('list');
print_r($commandData);
            //$output->title('Command List');
            $output->title($commandData['name'], 'yellow');
            $output->blank();

            $output->lineText("Description:", 'yellow');
            $output->lineText(" {$commandData['description']}");
            $output->blank();

            $usage = "  php bin/console list";

            if ($arguments = $commandData['arguments']) {
                $output->lineText("Arguments:", 'yellow');

                foreach ($arguments as $data) {
                    $output->lineText(" {$data['alias']},");
                    $usage .= " [{$data['alias']}]";
                }
            }
            $output->blank();

            if ($options = $commandData['options']) {
                $output->lineText("Options:", 'yellow');
                $output->blank();
                foreach ($options as $data) {
                    if (is_array($data['options'])) {
                        foreach ($data['options'] as $option) {
                            $output->text(" {$option},");
                        }
                    } else {
                        $output->lineText(" {$data['options']},");
                    }
                }

                $usage .= " [options]";
            }
            $output->blank();

            $output->lineText("Usage: ", 'yellow');
            $output->lineText($usage);
            $output->blank();

            $commands = $this->getGroup();
            $unlistedMaxWidthName = 0;
            $maxWidthName = 0;

            $commands[''][] = [
                'name'        => 'ASD',
                'description' => 'ajksdkasjdks',
            ];
            $commands[''][] = [
                'name'        => 'help',
                'description' => 'This is help command ha okey',
            ];

            $commands['app'][] = [
                'name'        => 'app:help',
                'description' => 'This is help This is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commanThis is help commancommand ha okey',
            ];

            foreach ($commands as $key => $data) {
                foreach ($data as $item) {
                    $nameLen = strlen($item['name']);

                    if (empty($key)) {
                        if ($unlistedMaxWidthName < $nameLen) {
                            $unlistedMaxWidthName = $nameLen;
                        }
                    }

                    if ($maxWidthName < $nameLen) {
                        $maxWidthName = $nameLen;
                    }
                }
            }

            foreach ($commands[''] as $data) {
                $extraSpace = str_repeat(" ", $unlistedMaxWidthName - strlen($data['name'])) . "   ";
                $write = "[{$data['name']}]" . $extraSpace . $data['description'];
                $output->lineText($write);
            }

            echo "\n";

            foreach ($commands as $key => $data) {
                if (!empty($key)) {
                    $output->lineText("[{$key}]");

                    foreach ($data as $item) {
                        $extraSpace = str_repeat(" ", $maxWidthName - strlen($item['name'])) . "   ";
                        $write = "- " . "[{$item['name']}]" . $extraSpace . $item['description'];
                        $output->lineText($write);
                    }

                    echo "\n";
                }
            }
        }


        private function getGroup()
        {
            $commands = CommandResource::getCommands();
            $listData = [];

            foreach ($commands as $command => $data) {
                if (!$data['namespace']) {
                    $listData[''][] = $data;
                } else {
                    $listData[$data['namespace']][] = $data;
                }
            }

            return $listData;
        }
    }