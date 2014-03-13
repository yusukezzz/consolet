<?php namespace Consolet;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class Command extends \Illuminate\Console\Command
{
    /**
     * @var \Pimple
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
        $name = snake_case($class);
        $name = preg_replace('/_?command/', '', last(explode('\\', $name)));
        return str_replace('_', ':', $name);
    }

    public function setContainer($container)
    {
        $this->container = $container;
        // set pimple instead of illuminate/foundation/application
        // it is possible to also use the command of laravel if array access
        $this->setLaravel($container);
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
