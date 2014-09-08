<?php namespace Consolet\Generators;

class CommandGenerator extends AbstractStubGenerator
{
    /**
     * path to commands dir
     *
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
        $path = $this->getPathCommands();
        if ( ! is_null($output = $this->command->option('output'))) {
            $path = $this->command->getWorkingPath() . DIRECTORY_SEPARATOR . $output;
        }
        if (is_null($path)) {
            throw new \RuntimeException('You should set paths.commands config key or --output option');
        }
        if ( ! is_dir($path)) {
            throw new \RuntimeException("Directory not exists or not directory: $path");
        }
        if ( ! is_writable($path)) {
            throw new \RuntimeException("Not writable: $path");
        }
        return $path;
    }

    public function getOutputFilename()
    {
        return $this->getCommandClassName().'.php';
    }

    public function getCommandClassName()
    {
        return ucfirst(camel_case($this->command->argument('name'))).'Command';
    }
}
