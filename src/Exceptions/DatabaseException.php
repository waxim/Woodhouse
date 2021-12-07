<?php declare(strict_types=1);

namespace Woodhouse\Exceptions;

class DatabaseException extends \Exception
{
    protected $message = 'Sorry, the database return an error. This command was not successful.';
}