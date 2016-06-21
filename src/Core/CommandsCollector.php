<?php

namespace Kisphp\Core;

use Kisphp\Command\ClearBranchesCommand;
use Symfony\Component\Console\Command\Command;

class CommandsCollector
{
    /**
     * @var array
     */
    protected $commands = [];

    public function __construct()
    {
        $this->commands = $this->getDefaultCommands();
    }

    /**
     * @param Command $command
     *
     * @return $this
     */
    public function addCommand(Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @return array
     */
    protected function getDefaultCommands()
    {
        $commands = [
            new ClearBranchesCommand(),
        ];

        return $commands;
    }
}
