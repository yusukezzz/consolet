<?php namespace Consolet;

use Consolet\Application;
use Consolet\Commands\AutoloadCommand;
use Consolet\Commands\GenerateCommand;

class DefaultCommandsProvider implements CommandProviderInterface
{
    public function registerCommands(Application $consolet)
    {
        $consolet->addCommands([new AutoloadCommand, new GenerateCommand]);
    }
}
