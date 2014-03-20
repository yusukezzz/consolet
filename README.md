## Consolet

[![Build Status](https://travis-ci.org/yusukezzz/consolet.png?branch=master)](https://travis-ci.org/yusukezzz/consolet)

simple cui wrapper

### install

    composer require yusukezzz/consolet:dev-master

### usage

```PHP
$console = \Consolet\Application::start();
$exit_cd = $console->run();
```

add your command

```PHP
<?php // cmd.php
require __DIR__ . '/vendor/autoload.php';
class HelloCommand extends \Consolet\Command
{
    // this command name is hello (auto set by Class name)
    // if you want to change it, edit $name property
    //protected $name = 'hey';
    public function fire()
    {
        $this->line('Hello World!');
    }
}
$console = \Consolet\Application::start();
$console->add(new HelloCommand);
exit($console->run());
```

exec in terminal


    $ php cmd.php hello
    Hello World!

using DI Container (Pimple)

```PHP
<?php // cmd.php
require __DIR__ . '/vendor/autoload.php';
class HogeCommand extends \Consolet\Command
{
    public function fire()
    {
        $this->line($this->container['hoge']);
    }
}
$console = \Consolet\Application::start(['hoge' => 'huga']);
// or \Consolet\Application::start(new \Pimple(['hoge' => 'huga']));
$console->add(new HogeCommand);
exit($console->run());
```

generate new command

    $ php cmd.php generate:command hoge --output=path/to/commands
    output: /path/to/commands/HogeCommand.php
    Command created successfully.

### License

MIT
