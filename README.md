## Consolet

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
    // this command name is hello (auto set by Class name if empty)
    // if you change it, comment out below line
    //protected $name = 'hey';
    public function fire()
    {
        $this->line('Hello world!');
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

**more info**

You should read [Laravel command docs](http://laravel.com/docs/commands "Laravel - The PHP Framework For Web Artisans.")

### License

MIT
