<?php declare(strict_types=1);

namespace Woodhouse;

use Illuminate\Database\Capsule\Manager as Capsule;

class Table
{
    /**
     * Return all our tables
     * 
     * @return array
     */
    public function list() : array
    {
        return Capsule::select("SELECT * FROM pg_catalog.pg_tables where schemaname = 'public'");
    }
}
