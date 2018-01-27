<?php

    namespace Eskirex\Component\Console;

    class Configuration
    {
        const BASE                      = __DIR__;

        const NAME              = 'Eskirex Console';
        const VERSION           = 'v1.0.0';

        const DEFAULT_COMMAND           = 'info';
        const DEFAULT_LANGUAGE          = 'en';
        
        const FALLBACK_LANGUAGE         = 'en';

        const HELP_OPTION               = '--help';
        const VERSION_OPTION            = '--version';
        const SILENT_OPTION             = '--silent';
        const NO_ANSI_OPTION            = '--no-ansi';
        const NO_QUESTION_OPTION        = '--no-question';

        const REGEX_LANGUAGE   = "'%(.*?)%'si";
        const REGEX_ANSI       = "'<(.*?)>'si";

        const COMPILE_REPLACE = [
            '<black>'       => "\033[38;5;0m",
            '<iblack>'      => "\033[38;5;8m",
            '<red>'         => "\033[38;5;1m",
            '<ired>'        => "\033[38;5;9m",
            '<green>'       => "\033[38;5;2m",
            '<igreen>'      => "\033[38;5;10m",
            '<yellow>'      => "\033[38;5;3m",
            '<iyellow>'     => "\033[38;5;11m",
            '<blue>'        => "\033[38;5;4m",
            '<iblue>'       => "\033[38;5;12m",
            '<purple>'      => "\033[38;5;5m",
            '<ipurple>'     => "\033[38;5;13m",
            '<cyan>'        => "\033[38;5;6m",
            '<icyan>'       => "\033[38;5;14m",
            '<white>'       => "\033[38;5;7m",
            '<iwhite>'      => "\033[38;5;15m",

            '<bg_black>'   => "\033[48;5;0m",
            '<bg_iblack>'  => "\033[48;5;8m",
            '<bg_red>'     => "\033[48;5;1m",
            '<bg_ired>'    => "\033[48;5;9m",
            '<bg_green>'   => "\033[48;5;2m",
            '<bg_igreen>'  => "\033[48;5;10m",
            '<bg_yellow>'  => "\033[48;5;3m",
            '<bg_iyellow>' => "\033[48;5;11m",
            '<bg_blue>'    => "\033[48;5;4m",
            '<bg_iblue>'   => "\033[48;5;12m",
            '<bg_purple>'  => "\033[48;5;5m",
            '<bg_ipurple>' => "\033[48;5;13m",
            '<bg_cyan>'    => "\033[48;5;6m",
            '<bg_icyan>'   => "\033[48;5;14m",
            '<bg_white>'   => "\033[48;5;7m",
            '<bg_iwhite>'  => "\033[48;5;15m",

            '<normal>'    => "\033[0m",
            '<b>'         => "\033[1m",
            '<dim>'       => "\033[2m",
            '<i>'         => "\033[3m",
            '<u>'         => "\033[4m",
            '<blink>'     => "\033[5m",
            '<reverse>'   => "\033[7m",
            '<invisible>' => "\033[8m",
            '<reset>'     => "\033[0m",
        ];


    }

