<?php

declare(strict_types=1);

namespace Src\Exceptions;

class NotReadable extends \RuntimeException
{
    protected $message = 'File or directory is not readable';
}