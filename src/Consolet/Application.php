<?php namespace Consolet;

use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * Console application name
     *
     * @var string
     */
    protected static $name = 'Consolet';

    /**
     * Console application version
     *
     * @var string
     */
    protected static $version = '0.0.1';

    /**
     * DI Container
     *
     * @var \Pimple
     */
    protected $container;

    /**
     * current working path
     *
     * @var string
     */
    protected $workingPath;

    /**
     * @param mixed $container
     * @return \Consolet\Application
     */
    public static function start($container = null)
    {
        if (is_array($container)) {
            $container = new \Pimple($container);
        }
        if ( ! ($container instanceof \Pimple)) {
            $container = new \Pimple();
        }
        /* @var $console Application */
        $console = new static(static::$name, static::$version);
        $console->setContainer($container)
                ->setAutoExit(false);
        return $console;
    }

    public function getWorkingPath()
    {
        return $this->workingPath ?: getcwd();
    }

    /**
     * @param $container
     * @return \Consolet\Application
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param $cwd
     * @return \Consolet\Application
     */
    public function setWorkingPath($cwd)
    {
        $this->workingPath = $cwd;
        return $this;
    }

    public function add(SymfonyCommand $command)
    {
        if ($command instanceof Command) {
            $command->setContainer($this->container);
        }
        return parent::add($command);
    }
}