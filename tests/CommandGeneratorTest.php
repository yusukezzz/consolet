<?php

use Consolet\Generators\CommandGenerator;
use Mockery as m;

class CommandGeneratorTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetOutputDir_path_and_output_both_empty()
    {
        $cmd = m::mock('Consolet\Command');
        $cmd->shouldReceive('option')->with('output')->andReturnNull();
        $gen = new CommandGenerator($cmd);
        $gen->getOutputDir();
    }

    public function testGetOutputDir_set_path_commands()
    {
        $path = __DIR__;
        $cmd = m::mock('Consolet\Command');
        $cmd->shouldReceive('option')->with('output')->andReturnNull();
        $gen = new CommandGenerator($cmd);
        $gen->setPathCommands($path);
        $this->assertSame($path, $gen->getOutputDir());
    }

    public function testGetOutputDir_set_output_option()
    {
        $output = '../tests';
        $cmd = m::mock('Consolet\Command');
        $cmd->shouldReceive('option')->with('output')->andReturn($output);
        $cmd->shouldReceive('getWorkingPath')->andReturn(__DIR__);
        $gen = new CommandGenerator($cmd);
        $expected_path = __DIR__ . DIRECTORY_SEPARATOR . $output;
        $this->assertSame($expected_path, $gen->getOutputDir());
    }

    public function testGetOutputDir_output_option_high_priority()
    {
        $path = 'path/to/commands';
        $output = '../tests';
        $cmd = m::mock('Consolet\Command');
        $cmd->shouldReceive('option')->with('output')->andReturn($output);
        $cmd->shouldReceive('getWorkingPath')->andReturn(__DIR__);
        $gen = new CommandGenerator($cmd);
        $gen->setPathCommands($path);
        $expected_path = __DIR__ . DIRECTORY_SEPARATOR . $output;
        $this->assertSame($expected_path, $gen->getOutputDir());
    }
}
