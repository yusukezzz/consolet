<?php namespace Consolet;

use Symfony\Component\Process\Process;

class Command extends \Illuminate\Console\Command
{
    /**
     * @var \Pimple\Container
     */
    protected $container;

    /**
     * @param string $name
     */
    public function __construct($name = null)
    {
        $this->initializeName($name);
        parent::__construct();
    }

    /**
     * @param string $class
     * @return string
     */
    public static function camelToCommand($class)
    {
        $class = last(explode('\\', $class));
        $name = snake_case($class);
        $name = preg_replace('/_?command/', '', $name);
        return str_replace('_', ':', $name);
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return \Consolet\Application
     */
    public function getApplication()
    {
        return parent::getApplication();
    }

    /**
     * alias of Application working path
     *
     * @return string
     */
    public function getWorkingPath()
    {
        return $this->getApplication()->getWorkingPath();
    }

    /**
     * @param string $name
     */
    protected function initializeName($name)
    {
        if (is_null($this->name)) {
            if ( is_null($name)) {
                $name = self::camelToCommand(get_called_class());
            }
            $this->name = $name;
        }
    }

    /**
     * @return \Symfony\Component\Process\Process
     */
    protected function getProcess()
    {
        $process = new Process('', $this->getApplication()->getWorkingPath());
        return $process->setTimeout(null);
    }
}
