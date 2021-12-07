<?php declare(strict_types=1);

namespace Woodhouse;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    /**
     * Get the name of our database
     * 
     * @return string
     */
    public static function name() : string
    {
        return Capsule::select("select current_database()")[0]->current_database;
    }
}
