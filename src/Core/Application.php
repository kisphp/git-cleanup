<?php

namespace Kisphp\Core;

use Cilex\Application as CilexApplication;
use Symfony\Component\Console\Command\Command;

class Application
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var CommandsCollector
     */
    protected $commandsCollector;

    /**
     * @param array $config
     */
    public function __construct(CommandsCollector $commandsCollector, array $config = [])
    {
        $applicationName = $config['name'];
        $applicationVersion = $config['version'];

        $this->app = new CilexApplication($applicationName, $applicationVersion);
        $this->commandsCollector = $commandsCollector;
    }

    /**
     * @param Command $command
     *
     * @return $this
     */
    public function registerCommand(Command $command)
    {
        $this->app->command($command);

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerCommandsList()
    {
        foreach ($this->commandsCollector->getCommands() as $command) {
            $this->registerCommand($command);
        }

        return $this;
    }

    /**
     * @return Application
     */
    public function boot()
    {
        $this->registerCommandsList();

        return $this->app;
    }
}
