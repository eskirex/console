<?php

    namespace Eskirex\Component\Console\Commands;

    use Eskirex\Component\Console\Command;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Manage;
    use Eskirex\Component\Console\Input;
    use Eskirex\Component\Console\Text;
    use Eskirex\Component\Console\Command\CommandManager;

    class HelpCommand extends Command
    {
        public function configure()
        {
            $this->setName('help')
                ->setDescription('Get command or commands help data')
                ->setHelp('You can use "command" argument for get other commands help data.')
                ->setArgument('command','For get other commands help data.')
            ;
        }


        public function execute(Input $input, Output $output)
        {
            echo 123;
            return;
            $commandArg = $input->getArgument('command');
            $commandData = CommandManager::getCommand($commandArg ?? 'help');

            if (!$commandData) {
                $output->writeIn("Error : Command({$commandArg}) not found.");
                $output->close();
            }
            $output->write("<color fore='iblack'>{$commandData['help']}<reset>");
            $output->blank();

            $output->writeIn("Command:", 'yellow');
            $output->writeIn(" <color fore='iblack'>{$commandData['name']}<reset>");
            $output->blank();

            $usage = " console list";

            if ($arguments = $commandData['arguments']) {
                $maxWidth = 0;
                $output->writeIn("Arguments:", 'yellow');

                foreach ($arguments as $data) {
                    $aliasLen = strlen($data['alias']);

                    if ($maxWidth < $aliasLen) {
                        $maxWidth = $aliasLen;
                    }
                }

                foreach ($arguments as $data) {
                    $aliasLen = strlen($data['alias']);
                    $extraSpace = str_repeat(" ", $maxWidth - $aliasLen) . "  ";
                    $output->writeIn(" <color fore='iblack'>{$data['alias']}{$extraSpace}{$data['description']}<reset>");
                    $usage .= " [{$data['alias']}]";
                }
                $output->blank();
            }

            if ($options = $commandData['options']) {
                $maxWidth = 0;
                $output->writeIn("Options:");

                foreach ($options as $data) {
                    $option = '';
                    if (is_array($data['options'])) {
                        foreach ($data['options'] as $key => $item) {
                            $option .= $item . ($key !== count($data['options']) - 1 ? ", " : "");
                        }
                    } else {
                        $option = $data['options'];
                    }

                    $aliasLen = strlen($option);

                    if ($maxWidth < $aliasLen) {
                        $maxWidth = $aliasLen;
                    }
                }

                foreach ($options as $data) {
                    $option = '';
                    if (is_array($data['options'])) {
                        foreach ($data['options'] as $key => $item) {
                            $option .= $item . ($key !== count($data['options']) - 1 ? ", " : "");
                        }
                    } else {
                        $option = $data['options'];
                    }

                    $aliasLen = strlen($option);
                    $extraSpace = str_repeat(" ", $maxWidth - $aliasLen) . "  ";
                    $output->writeIn(" <color fore='iblack'>{$option}{$extraSpace}{$data['description']}<reset>");
                }
                $usage .= " [options]";
                $output->blank();
            }

            $output->writeIn("Usage: ");
            $output->writeIn("<color fore='iblack'>{$usage}<reset>");
        }
    }