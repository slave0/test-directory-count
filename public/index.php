<?php

use Src\GetSumFiles;

require_once '../vendor/autoload.php';

echo (new GetSumFiles())->execute(['/var/www/dir']);