<?php declare(strict_types=1);

namespace Woodhouse;

use Illuminate\Database\Capsule\Manager as Capsule;
use Woodhouse\Operations\{Select,
    Insert,
    Update,
    Delete};

class Woodhouse
{
    /**
     * What our our operations
     * 
     * @var array
     */
    public static $operations = [
        Select::NAME,
        Insert::NAME,
        Update::NAME,
        Delete::NAME
    ];

    /**
     * Return our database class
     * 
     * @return Database
     */
    public function database()
    {
        return new Database;
    }

    /**
     * Return our table class
     * 
     * @return Table
     */
    public function table()
    {
        return new Table;
    }

    /**
     * Return our user class
     * 
     * @return User
     */
    public function user()
    {
        return new User;
    }
}
