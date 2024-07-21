<?php

declare(strict_types=1);

namespace Src\Exceptions;

class DirectoryNotExists extends \RuntimeException
{
    protected $message = 'Directory doesn\'t exist';
}