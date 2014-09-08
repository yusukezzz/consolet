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
        $this->generator->setPathCommands($this->config('paths.commands'));
        $this->comment('output: '.$this->generator->getOutputPath());
        if ($this->generator->execute($replacement)) {
            $this->info('Command created successfully.');
        } else {
            $this->error('Command already exists.');
        }
    }

    protected function getArguments()
    {
        return [
            $this->argumentModeRequired('name', 'command name'),
        ];
    }

    protected function getOptions()
    {
        return [
            $this->optionModeOptional('output', 'command store path (relative from cwd)'),
            $this->optionModeOptional('namespace', 'command namespace'),
        ];
    }
}
