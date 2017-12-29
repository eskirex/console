<?php
require __DIR__ . '/vendor/autoload.php';

use Eskirex\Component\Console\Command;
use Eskirex\Component\Console\Console;
use Eskirex\Component\Console\Text;

use Symfony\Component\Console\Command\Command as SCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends SCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:create-user')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}

class deneme extends Command
{
    protected function configure()
    {
        $this
            ->setName('deneme')
            ->setDescription('deneme descriptionu')
            ->setHelp('deneme helpi');

    }


    protected function execute()
    {

    }


    public function index()
    {
        $data = [];
        foreach ($this->commands() as $key => $value) {
            $data[] = [
                'command'     => $key,
                'description' => $value['description'],
                'callback'    => $value['callback']
            ];
        }

        return $this->table($data);
    }
}

$a = new deneme();
echo Command::$bag;
exit;
$a = new \Eskirex\Component\Console\AddCommand();

$a->name('commands')
    ->description('Show all defined commands')
    ->help('testhelp')
    ->callback(deneme::class)
    ->add();

$a->name('can2')
    ->description('test')
    ->help('testhelp')
    ->callback('callbackk2')
    ->add();

$b = new \Eskirex\Component\Console\Execute();
