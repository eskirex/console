<?php
require __DIR__ . '/vendor/autoload.php';

use Eskirex\Component\Console\Console;

$a = new Console();
$a->add('can')
    ->description('test')
    ->help('testhelp')
    ->callback('callbackk');



$a->add('can2')
    ->description('test')
    ->help('testhelp')
    ->callback('callbackk');

$a->run();



