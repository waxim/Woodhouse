<?php

use Woodhouse\Woodhouse;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseTest extends TestCase
{
    public function testDatabase()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'pgsql',
            'host' => '0.0.0.0',
            'database' => 'laravel',
            'username' => 'sail',
            'password' => 'password',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $woodhouse = new Woodhouse;
        $name = $woodhouse->database()->name();
        $this->assertSame($name, 'laravel');
    }
}