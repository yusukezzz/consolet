<?php

use Consolet\Generators\CommandGenerator;
use Mockery as m;

class CommandGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testGetOutputDir_output_dir_empty()
    {
        $cmd = m::mock('Consolet\Command');
        $cmd->shouldReceive('option')->with('output')->andReturnNull();
        $gen = new CommandGenerator($cmd);
        $gen->getOutputPath();
    }
}
