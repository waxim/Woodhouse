<?php declare(strict_types=1);

namespace Woodhouse;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;
use Woodhouse\Exceptions\{DatabaseException,
    RootUserCanNotBeAltered};
use Woodhouse\Operations\Select;
use Woodhouse\Woodhouse;

class User
{
    /**
     * Get all users
     * 
     * @throws DatabaseException
     * @return array
     */
    public function list() : ?array
    {
        try { 
            $list = Capsule::select('select * from pg_catalog.pg_user');
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }

        return $list;
    }

    /**
     * Create a new user
     * 
     * @param string $username
     * @param string $password
     * @throws DatabaseException
     *
     * @return void
     */
    public function create(string $username, string $password)
    {
        # Dont allow us to create a user called postgres
        if ($username === 'postgres') {
            throw new RootUserCanNotBeAltered;
        }

        try {
            Capsule::select("create user {$username} with password '{$password}'");
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * Delete a user
     * 
     * @param string $username
     * @throws DatabaseException
     *
     * @return void
     */
    public function delete(string $username)
    {
        # Prevent root user being dropped
        if ($username === 'postgres') {
            throw new RootUserCanNotBeAltered;
        }

        try {
            Capsule::select("drop user {$username}");
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * Get a users permissions
     * 
     * @param string $username
     * @throws DatabaseException
     *
     * @return array
     */
    public function permissions(string $username)
    {
        try {
            $permissions = Capsule::select("select * from information_schema.role_table_grants where grantee = '{$username}'");
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }

        return $permissions;
    }

    /**
     * Allow a user to see a certain table
     * 
     * @param string $username
     * @param string $table
     * @param array $actions
     * @throws DatabaseException
     *
     * @return void
     */
    public function allow(string $username, string $table, array $actions = [Select::NAME])
    {
        # Dont allow updating of root user
        if ($username === 'postgres') {
            throw new RootUserCanNotBeAltered;
        }

        # Filter to only allow select, insert, update, delete
        $actions = array_intersect($actions, Woodhouse::$operations);
        try {
            Capsule::select('grant ' . implode(', ', $actions).' on '.$table.' to '.$username);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * Deny a user to see a certain table
     * 
     * @param string $username
     * @param string $table
     * @param array $actions
     * @throws DatabaseException
     *
     * @return void
     */
    public function deny(string $username, string $table, array $actions = [Select::NAME])
    {
        # Dont allow updating of root user
        if ($username === 'postgres') {
            throw new RootUserCanNotBeAltered;
        }

        # Filter to only allow select, insert, update, delete
        $actions = array_intersect($actions, Woodhouse::$operations);
        try {
            Capsule::select('revoke ' . implode(', ', $actions).' on '.$table.' from '.$username);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * Test if a user has a certain permission for a table
     * 
     * @param string $username
     * @param string $table
     * @param string $action
     * @throws DatabaseException
     * @return bool
     */
    public function has(string $username, string $table, string $action) : ?bool
    {
        try {
            $permissions = Capsule::select("select * from information_schema.role_table_grants where grantee = '{$username}' and table_name = '{$table}'");
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }

        foreach($permissions as $permission) {
            if(strtolower($permission->privilege_type) === $action) {
                return true;
            }
        }

        return false;
    }
}
