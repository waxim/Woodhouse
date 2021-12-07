<?php declare(strict_types=1);

namespace Woodhouse\Exceptions;

class RootUserNotBeAltered extends \Exception
{
    protected $message = 'Sorry, but root user can not be altered';
}