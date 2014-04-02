<?php namespace Consolet;

interface CommandProviderInterface
{
    public function registerCommands(Application $consolet);
}
