<?php namespace Consolet;

use Illuminate\Filesystem\Filesystem;
use Pimple\Container;
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
    protected static $version = '0.1.4';

    /**
     * DI Container
     *
     * @var Container
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
            $container = new Container($container);
        }
        if ( ! ($container instanceof Container)) {
            $container = new Container();
        }
        $container = self::prepareContainer($container);
        /* @var $console Application */
        $console = new static(static::$name, static::$version);
        $console->setContainer($container)
                ->mergeDefaultConfig()
                ->setAutoExit(false)
                ->loadProviders();
        return $console;
    }

    /**
     * prepare default dependencies
     *
     * @param Container $container
     * @return Container
     */
    public static function prepareContainer(Container $container)
    {
        if ( ! isset($container['config'])) {
            $container['config'] = [];
        }
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
     * @return Container
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

    /**
     * @return \Consolet\Application
     */
    protected function mergeDefaultConfig()
    {
        $default = [
            'paths.base' => $this->getWorkingPath(),
            'paths.commands' => $this->getWorkingPath() . '/commands',
        ];
        $config = $this->container['config'];
        $this->container['config'] = array_merge($default, $config);
        return $this;
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