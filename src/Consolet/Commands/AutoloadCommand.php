<?php namespace Consolet\Commands;

use Illuminate\Filesystem\Filesystem;

class AutoloadCommand extends \Consolet\Command
{
    protected $name = 'dump-autoload';
    protected $description = 'exec composer dump-autoload command';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct($files = null)
    {
        parent::__construct();
        if (is_null($files)) $files = new Filesystem();
        $this->files = $files;
    }

    public function fire()
    {
        $process = $this->getProcess();
        $process->setCommandLine($this->findComposer() . ' dump-autoload');
        $process->run();
    }

    protected function findComposer()
    {
        if ($this->files->exists($this->getWorkingPath().'/composer.phar')) {
            return 'php composer.phar';
        }
        return 'composer';
    }
}
