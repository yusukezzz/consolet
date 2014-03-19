<?php namespace Consolet\Commands;

use Consolet\Generators\CommandGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateCommand extends \Consolet\Command
{
    protected $name = 'generate:command';

    protected $description = 'Create a new command';

    /**
     * @var \Consolet\Generators\CommandGenerator
     */
    protected $generator;

    public function __construct(CommandGenerator $generator = null)
    {
        parent::__construct();
        $this->generator = $generator ?: new CommandGenerator($this);
    }

    public function fire()
    {
        $namespace = $this->option('namespace');
        if ( ! is_null($namespace)) {
            $namespace = ' namespace '.$namespace.';';
        }
        $replacement = [];
        $replacement['{{class}}'] = $this->generator->getCommandClassName();
        $replacement['{{namespace}}'] = (string) $namespace;
        $this->generator->setPathCommands($this->container['path.commands']);
        $this->comment('output: '.$this->generator->getOutputPath());
        if ($this->generator->execute($replacement)) {
            $this->info('Command created successfully.');
        } else {
            $this->error('Command already exists.');
        }
    }

    protected function getArguments()
    {
        return array(
            array('name', null, InputArgument::REQUIRED, 'command class name'),
        );
    }

    protected function getOptions()
    {
        return array(
            array('output', null, InputOption::VALUE_OPTIONAL, 'command store path', null),
            array('namespace', null, InputOption::VALUE_OPTIONAL, 'command namespace', null),
        );
    }
}
