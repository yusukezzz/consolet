<?php namespace Consolet\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateCommand extends StubGeneratorCommand
{
    protected $name = 'generate:command';

    protected $description = 'Create a new command';

    public function fire()
    {
        $replacement = [
            '{{class}}' => $this->input->getArgument('name'),
        ];
        $namespace = $this->input->getOption('namespace');
        if ( ! is_null($namespace)) {
            $namespace = ' '.$namespace;
        }
        $replacement['{{namespace}}'] = (string) $namespace;
        $this->generate($replacement);

        $this->info('generate command successfully');
    }

    protected function getOutputFilename()
    {
        return $this->input->getArgument('name').'.php';
    }

    /**
     * save formatted stub text
     *
     * @param string $stub
     * @return mixed
     */
    protected function store($stub)
    {
        $path = $this->container['path'].'/commands/'.$this->getOutputFilename();
        return $this->files->put($path, $stub);
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

    protected function getOptions()
    {
        $options = parent::getOptions();
        $options[] = array('namespace', null, InputOption::VALUE_OPTIONAL, 'command namespace', null);
        return $options;
    }
}
