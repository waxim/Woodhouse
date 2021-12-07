<?php declare(strict_types=1);

namespace Woodhouse\Exceptions;

class OperationNotAllowed extends \Exception
{
    protected $message = 'Sorry, this operation is not allowed';
}