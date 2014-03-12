<?php namespace Consolet\Commands;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class StubGeneratorCommand extends \Consolet\Command
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files = null, $name = null)
    {
        parent::__construct($name);
        if (is_null($files)) $files = new Filesystem();
        $this->files = $files;
    }

    protected function generate(array $replacement)
    {
        $stub = $this->formatStub($this->getStub(), $replacement);
        $this->store($stub);
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
     * @return mixed
     */
    abstract protected function store($stub);

    /**
     * get stub text
     *
     * @return string
     */
    abstract protected function getStub();

    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'stub class name'),
        );
    }

    protected function getOptions()
    {
        return array(
            array('output', null, InputOption::VALUE_OPTIONAL, 'stub stored path', null),
        );
    }
}
