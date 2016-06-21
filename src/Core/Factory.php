<?php

namespace Kisphp\Core;

class Factory
{
    const CONFIG_NAME = 'Kisphp-GIT-CLEANUP';
    const CONFIG_VERSION = '0.1.0';

    const PARAM_NAME = 'name';
    const PARAM_VERSION = 'version';

    /**
     * @return Application
     */
    public static function createApplication()
    {
        $commandsCollector = static::createCommandsCollector();
        $app = new Application($commandsCollector, [
            self::PARAM_NAME => static::CONFIG_NAME,
            self::PARAM_VERSION => static::CONFIG_VERSION,
        ]);

        return $app;
    }

    /**
     * @return CommandsCollector
     */
    public static function createCommandsCollector()
    {
        return new CommandsCollector();
    }
}
