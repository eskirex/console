<?php

    namespace Eskirex\Component\Console;

    use Eskirex\Component\Console\Command\CommandManager;
    use Eskirex\Component\Console\Command\Interfaces\CommandInterface;
    use Eskirex\Component\Console\Commands\InfoCommand;
    use Eskirex\Component\Console\Output\Translator;
    use Eskirex\Component\Console\Output\Writer;
    use Eskirex\Component\Console\Input\InputManager;

    class Console
    {
        public static $name;

        public static $version;

        public static $language;

        /**
         * @var CommandInterface
         */
        private $callback;


        public function __construct(string $name = null, string $version = null, string $language = null)
        {
            self::$name = $name;
            self::$version = $version;
            self::$language = $language;

            $this->addCommand(new InfoCommand());
        }


        public function addCommand($command)
        {
            CommandManager::setCallback($command);

            return $this;
        }


        public function run(Input $input, Output $output)
        {
            if (!array_key_exists(InputManager::getCommand(), CommandManager::getCommands())) {

                $output->writeIn("<bg_ired><black><b> %error% <reset> : <iblack>%console.error% (" . InputManager::getCommand() . ")<reset>");
                $output->blank();

                $runList = $output->ask("%console.ask%",
                    [
                        '%question.key.yes%' => '%console.option.desc%',
                        '%question.key.no%'  => '%console.option.desc2%',
                    ], "%question.key.yes%");

                if ($runList === Translator::getValue('question.key.yes')) {
                    $command = Configuration::DEFAULT_COMMAND;
                } else {
                    exit();
                }
            }


            if (InputManager::getOption(Configuration::HELP_OPTION) || InputManager::getOption(Configuration::VERSION_OPTION)) {

                $command = Configuration::DEFAULT_COMMAND;
            }else{
                if (array_key_exists(InputManager::getCommand(), CommandManager::getCommands())) {

                    $command = InputManager::getCommand();
                }

            }

            return $this->execute($command, $input, $output);
        }


        private function execute(string $command, Input $input, Output $output)
        {
            $data = CommandManager::getCommand($command);
            $callback = CommandManager::getCallback($data['callback']);

            return $callback->execute($input, $output);
        }


        public static function getName()
        {
            return self::$name ?? Translator::getValue('default_application_name');
        }


        public static function getVersion()
        {
            return self::$version ?? Translator::getValue('default_application_version');
        }


        public static function getLanguage()
        {
            return self::$language ?? Configuration::DEFAULT_LANGUAGE;
        }
    }