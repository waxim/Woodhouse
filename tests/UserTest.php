<?php

use Woodhouse\Woodhouse;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class UserTest extends TestCase
{
    protected $woodhouse;

    public function setUp() : void
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
        $this->woodhouse = (new Woodhouse);
    }

    public function testWeCanFetchUsers()
    {
        $users = $this->woodhouse->user()->list();
        $this->assertTrue(count($users) > 0);
    }

    public function testWeCanCreateAndDestroyAUser()
    {
        $user = $this->woodhouse->user()->create('testing', 'testing');
        $users = $this->woodhouse->user()->list();
        $names = [];
    
        foreach($users as $usename){
            $names[] = $usename->usename;
        }

        $this->assertTrue(in_array('testing', $names));

        $this->woodhouse->user()->delete('testing');
        $users = $this->woodhouse->user()->list();
        $names = [];

        foreach($users as $usename){
            $names[] = $usename->usename;
        }

        $this->assertFalse(in_array('testing', $names));
    }

    public function testWeCanGiveAndTakeAwayPermissionsToATable()
    {
        Capsule::schema()->create('testing_table', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });

        $user = $this->woodhouse->user()->create('testing', 'testing');
        $has_permission = $this->woodhouse->user()->has('testing', 'testing_table', 'select');

        $this->woodhouse->user()->allow('testing', 'testing_table');
        $has_permission = $this->woodhouse->user()->has('testing', 'testing_table', 'select');

        $this->assertTrue($has_permission);

        $this->woodhouse->user()->deny('testing', 'testing_table');
        $has_permission = $this->woodhouse->user()->has('testing', 'testing_table', 'select');

        $this->assertFalse($has_permission);

        Capsule::schema()->drop('testing_table');
        $this->woodhouse->user()->delete('testing');
    }
}
