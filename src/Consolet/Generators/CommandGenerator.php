<?php namespace Consolet\Generators;

class CommandGenerator extends AbstractStubGenerator
{
    /**
     * path to commands dir
     * @var string
     */
    protected $pathCommands = null;

    public function getPathCommands()
    {
        return $this->pathCommands;
    }

    public function setPathCommands($path)
    {
        $this->pathCommands = $path;
    }

    /**
     * get stub text
     *
     * @return string
     */
    public function getStub()
    {
        return $this->files->get(__DIR__ . '/stubs/command.php');
    }

    public function getOutputDir()
    {
        $path = null;
        if ( ! is_null($this->getPathCommands())) {
            $path = $this->getPathCommands();
        }
        if ( ! is_null($output = $this->command->option('output'))) {
            $path = $output;
        }
        if (is_null($path)) {
            throw new \RuntimeException('You should set path.commands container key or --output option');
        }
        return $path;
    }

    public function getOutputFilename()
    {
        return $this->command->argument('name').'Command.php';
    }
}
