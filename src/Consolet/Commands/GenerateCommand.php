<?php namespace Consolet\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateCommand extends \Consolet\StubGeneratorCommand
{
    protected $name = 'generate:command';

    protected $description = 'Create a new command';

    public function fire()
    {
        $namespace = $this->input->getOption('namespace');
        if ( ! is_null($namespace)) {
            $namespace = ' namespace '.$namespace.';';
        } else {
            $namespace = ' namespace Consolet\\Commands;';
        }
        $replacement = [];
        $replacement['{{class}}'] = $this->input->getArgument('name');
        $replacement['{{namespace}}'] = (string) $namespace;
        $this->generate($replacement);

        $this->comment($this->getOutputPath());
        $this->info('generate command successfully');
    }

    /**
     * get stub text
     *
     * @return string
     */
    protected function getStub()
    {
        $path = __DIR__ . '/stubs/command.php';
        return $this->files->get($path);
    }

    protected function getOutputDir()
    {
        $path = null;
        if (isset($this->container['path.commands'])) {
            $path = $this->container['path.commands'];
        }
        if ( ! is_null($output = $this->input->getOption('output'))) {
            $path = $output;
        }
        if (is_null($path)) {
            throw new \RuntimeException('You should set path.commands container key or --output option');
        }
        return $path;
    }

    protected function getOutputFilename()
    {
        return $this->input->getArgument('name').'.php';
    }

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options[] = array('namespace', null, InputOption::VALUE_OPTIONAL, 'command namespace', null);
        return $options;
    }
}
