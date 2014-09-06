<?php namespace Consolet;

use Illuminate\Filesystem\Filesystem;
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
    protected static $version = '0.1.2';

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
        $container = self::prepareContainer($container);
        /* @var $console Application */
        $console = new static(static::$name, static::$version);
        $console->setContainer($container)
                ->setAutoExit(false)
                ->loadProviders();
        return $console;
    }

    /**
     * prepare default dependencies
     *
     * @param \Pimple $container
     * @return \Pimple
     */
    public static function prepareContainer(\Pimple $container)
    {
        if ( ! isset($container['files'])) {
            $container['files'] = new Filesystem();
        }
        if ( ! isset($container['providers'])) {
            $container['providers'] = [];
        }
        $providers = $container['providers'];
        $providers[] = 'Consolet\DefaultCommandsProvider';
        $container['providers'] = $providers;
        return $container;
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
     * @return \Pimple
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param string $cwd
     * @return \Consolet\Application
     */
    public function setWorkingPath($cwd)
    {
        $this->workingPath = $cwd;
        return $this;
    }

    /**
     * @param bool $bool
     * @return \Consolet\Application
     */
    public function setAutoExit($bool)
    {
        parent::setAutoExit($bool);
        return $this;
    }


    public function add(SymfonyCommand $command)
    {
        if ($command instanceof Command) {
            $command->setContainer($this->container);
        }
        return parent::add($command);
    }

    protected function loadProviders()
    {
        foreach ($this->container['providers'] as $provider_class) {
            /* @var $provider \Consolet\CommandProviderInterface */
            $provider = new $provider_class;
            $provider->registerCommands($this);
        }
    }
}