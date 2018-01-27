<?php

    namespace Eskirex\Component\Console\Commands;

    use Eskirex\Component\Console\Command;
    use Eskirex\Component\Console\Configuration;
    use Eskirex\Component\Console\Console;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Input;

    class InfoCommand extends Command
    {
        protected function configure()
        {
            $this->setName('info')
                ->setDescription('%info.description%')
                ->setHelp("%info.help%")
                ->setVersion('v1.0.0')
            ;
        }


        public function execute(Input $input, Output $output)
        {
            if (Input\InputManager::getOption(Configuration::HELP_OPTION)) {
                return $this->help($input, $output);
            }

            if (Input\InputManager::getOption(Configuration::VERSION_OPTION)) {
                return $this->version($input, $output);
            }

            $cliName = Configuration::NAME;
            $cliVersion = Configuration::VERSION;
            $appName = Console::getName();
            $appVersion = Console::getVersion();
            $appLanguage = Console::getLanguage();
            $commands = Command\CommandManager::getCommands();
            $unlistedMaxWidthName = 0;
            $maxWidthName = 0;

            $output->write("
%info.help%
<iyellow>%info.cli%<reset>
  <iblack>{$cliName} <i>{$cliVersion}<reset>
    
<iyellow>%info.application%<reset>
  <iblack>{$appName} <i>{$appVersion}<reset>
  
<iyellow>%info.application_language%<reset>
  <iblack>{$appLanguage}<reset>
    
<iyellow>%info.standart_options%<reset>
  <iwhite>--help<reset>         <iblack>%info.option.help%<reset>
  <iwhite>--version<reset>      <iblack>%info.option.version%<reset>
  <iwhite>--silent<reset>       <iblack>%info.option.silent%<reset>
  <iwhite>--no-ansi<reset>      <iblack>%info.option.no_ansi%<reset>
  <iwhite>--no-question<reset>  <iblack>%info.option.no_question%<reset>
");
            $output->writeIn('<iyellow>%info.commands%<reset>');
            $commandGroup = [];

            foreach ($commands as $command => $data) {
                if (!$data['namespace']) {
                    $commandGroup[''][] = $data;
                } else {
                    $commandGroup[$data['namespace']][] = $data;
                }
            }

            foreach ($commandGroup as $key => $data) {
                foreach ($data as $item) {
                    $nameLen = mb_strlen($item['name']);

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

            foreach ($commandGroup[''] as $data) {
                $extraSpace = str_repeat(" ", $unlistedMaxWidthName - mb_strlen($data['name'])) . " ";
                $write = "  <iwhite>{$data['name']}<reset>{$extraSpace} <iblack>{$data['description']}<reset>";
                $output->writeIn($write);
            }

            $output->blank();

            foreach ($commandGroup as $key => $data) {
                if (!empty($key)) {
                    $output->writeIn("  <iwhite>[{$key}]<reset>");

                    foreach ($data as $item) {
                        $extraSpace = str_repeat(" ", $maxWidthName - mb_strlen($item['name'])) . " ";
                        $write = "    <iwhite>{$item['name']}<reset>{$extraSpace} <iblack>{$item['description']}<reset>";
                        $output->writeIn($write);
                    }

                    $output->blank();
                }
            }
        }


        private function help(Input $input, Output $output)
        {
            $command = $input->getCommand();
            $commandData = Command\CommandManager::getCommand($command);
            $output->writeIn($commandData['help']);
            $output->blank();
            $usageWrite = "\n<iyellow>%info.help.usage%<reset>\n  <iblack>{$command}<reset> ";

            if ($commandData['arguments']) {
                $argumentsWrite = "\n<iyellow>%info.help.arguments%<reset>\n";
                $aliasMaxWidth = max(array_map('mb_strlen', array_column($commandData['arguments'], 'alias')));

                foreach ($commandData['arguments'] as $key => $value) {
                    $extraSpaceForAlias = str_repeat(" ", $aliasMaxWidth - mb_strlen($value['alias']));

                    $argumentsWrite .= "  {$value['alias']} {$extraSpaceForAlias} <iblack>{$value['description']}<reset>\n";
                    $usageWrite .= "<iblack>[{$key}]<reset> ";
                }
            }
            $usageWrite .= "<iblack>[%info.help.options2%]<reset>\n";

            if ($commandData['options']) {
                $optionsWrite = "\n<iyellow>%info.help.options%<reset>\n";
                $nameMaxWidth = max(array_map('mb_strlen', array_column($commandData['options'], 'name')));
                $shortcutMaxWidth = max(array_map('mb_strlen', array_column($commandData['options'], 'shortcut')));

                foreach ($commandData['options'] as $key => $value) {
                    $extraSpaceForName = str_repeat(" ", $nameMaxWidth - mb_strlen($value['name']));
                    $extraSpaceForShortcut = str_repeat(" ", $shortcutMaxWidth - mb_strlen($value['shortcut']));
                    $optionsWrite .= "  --{$value['name']} {$extraSpaceForName} -{$value['shortcut']} {$extraSpaceForShortcut} <iblack>{$value['description']}<reset>\n";
                }
            }

            $output->write($usageWrite);
            if (isset($argumentsWrite)) {
                $output->write($argumentsWrite);
            }
            if (isset($optionsWrite)) {
                $output->write($optionsWrite);
            }
        }


        private function version(Input $input, Output $output)
        {
            $command = $input->getCommand();
            $commandData = Command\CommandManager::getCommand($command);
            $version = $commandData['version'] ?? "%info.unknown_version%";
            $output->write("{$input->getCommand()} {$version}");
        }
    }