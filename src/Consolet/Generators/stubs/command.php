<?php{{namespace}}

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class {{class}} extends \Consolet\Command {

    /**
     * The console command name.
     *
     * @var string
     */
    //protected $name = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            $this->argumentModeRequired('example', 'An example argument.'),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            $this->optionModeOptional('example', 'An example option.'),
        ];
    }

}