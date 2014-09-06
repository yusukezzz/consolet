<?php namespace Consolet;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
     * Build required argument rule
     *
     * @param string $name
     * @param string $description
     * @param mixed $defaultValue
     * @return array
     */
    public function argumentModeRequired($name, $description, $defaultValue = null)
    {
        $mode = InputArgument::REQUIRED;
        return [$name, $mode, $description, $defaultValue];
    }

    /**
     * Build optional argument rule
     *
     * @param string $name
     * @param string $description
     * @param mixed $defaultValue
     * @return array
     */
    public function argumentModeOptional($name, $description, $defaultValue = null)
    {
        $mode = InputArgument::OPTIONAL;
        return [$name, $mode, $description, $defaultValue];
    }

    /**
     * Build required option rule
     *
     * @param string $name
     * @param string $description
     * @param mixed $defaultValue
     * @return array
     */
    public function optionModeRequired($name, $description, $defaultValue = null)
    {
        $shortcut = null;
        $mode = InputOption::VALUE_REQUIRED;
        return [$name, $shortcut, $mode, $description, $defaultValue];
    }

    /**
     * Build optional option rule
     *
     * @param string $name
     * @param string $description
     * @param mixed $defaultValue
     * @return array
     */
    public function optionModeOptional($name, $description, $defaultValue = null)
    {
        $shortcut = null;
        $mode = InputOption::VALUE_OPTIONAL;
        return [$name, $shortcut, $mode, $description, $defaultValue];
    }

    /**
     * Build multiple values option rule
     * ex) --hoge_option=bar --hoge_option=baz
     *
     * @param string $name
     * @param string $description
     * @param mixed $defaultValue
     * @return array
     */
    public function optionModeArray($name, $description, $defaultValue = null)
    {
        $shortcut = null;
        $mode = InputOption::VALUE_IS_ARRAY;
        return [$name, $shortcut, $mode, $description, $defaultValue];
    }

    /**
     * Build no value option rule
     * ex) --hoge_option
     *
     * @param string $name
     * @param string $description
     * @return array
     */
    public function optionModeNoValue($name, $description)
    {
        $shortcut = null;
        $mode = InputOption::VALUE_NONE;
        return [$name, $shortcut, $mode, $description, $defaultValue = null];
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
