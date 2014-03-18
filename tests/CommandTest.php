<?php

use Consolet\Command;

class CommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider classNameProvider
     */
    public function testCamelToCommand($class, $expected)
    {
        $cmd = new Command('test');
        $this->assertSame($expected, $cmd->camelToCommand($class));
    }

    public function classNameProvider()
    {
        return [
            ['Command', ''],
            ['HogeCommand', 'hoge'],
            ['HogeHugaCommand', 'hoge:huga'],
            ['Hoge', 'hoge'],
            ['HogeHuga', 'hoge:huga'],
            ['Console\\Commands\\HogeHuga', 'hoge:huga'],
        ];
    }
}
