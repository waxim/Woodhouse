<?php

require "./vendor/autoload.php";

use Woodhouse\Woodhouse;
use Illuminate\Database\Capsule\Manager as Capsule;

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
$woodhouse = new Woodhouse($capsule);

$users = $woodhouse->user()->list();

//foreach($users as $user) {
//    echo $user->usename . PHP_EOL;
//}

# Add a new user
//$user = $woodhouse->user()->create("test", "test");

# Gran select permissions to submissions
//$table = $woodhouse->user()->allow('test','submissions', ['select', 'update']);

# Dent select permissions to submissions
//$table = $woodhouse->user()->deny('test','submissions');

# See all a users permissions
//$table = $woodhouse->user()->permissions('test');
//print_r($table);

# Show all tables
//$tables = $woodhouse->table()->list();

//foreach($tables as $table) {
//    echo $table->tablename . PHP_EOL;
//}

// test we can get all users
//$users = $woodhouse->user()->list();
//print_r($users);

$has_permission = $woodhouse->user()->has('testing', 'testing_table', 'select');
var_dump($has_permission);