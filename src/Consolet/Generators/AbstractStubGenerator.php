<?php namespace Consolet\Generators;

use Illuminate\Filesystem\Filesystem;

abstract class AbstractStubGenerator
{
    /**
     * @var \Consolet\Command
     */
    protected $command;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(\Consolet\Command $command, Filesystem $files = null)
    {
        $this->command = $command;
        if (is_null($files)) $files = new Filesystem();
        $this->files = $files;
    }

    /**
     * @param array $replacement
     * @return bool
     */
    public function generate(array $replacement)
    {
        $stub = $this->formatStub($this->getStub(), $replacement);
        return $this->store($stub);
    }

    public function getOutputPath()
    {
        return $this->getOutputDir() . '/' . $this->getOutputFilename();
    }

    /**
     * replace stub text
     *
     * @param string $stub
     * @param array $replacement
     * @return string
     */
    protected function formatStub($stub, array $replacement)
    {
        foreach ($replacement as $src => $dest) {
            $stub = str_replace($src, $dest, $stub);
        }
        return $stub;
    }

    /**
     * save formatted stub text
     *
     * @param string $stub
     * @return bool
     */
    protected function store($stub)
    {
        $output = $this->getOutputPath();
        if ($this->files->exists($output)) {
            return false;
        }
        $this->files->put($output, $stub);
        return true;
    }

    /**
     * get stub text
     *
     * @return string
     */
    abstract protected function getStub();

    abstract protected function getOutputDir();

    abstract protected function getOutputFilename();
}
