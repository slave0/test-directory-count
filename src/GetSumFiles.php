<?php

declare(strict_types=1);

namespace Src;

use FilesystemIterator;
use Src\Exceptions\DirectoryNotExists;
use Src\Exceptions\NotReadable;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class GetSumFiles
{
    private const SEARCH_FILE = 'count';

    /** @var float  */
    private float $sum = 0;

    /**
     * @param string[] $paths
     * @return float
     */
    public function execute(array $paths): float
    {
        foreach ($paths as $path) {
            $this->checkDirectory($path);
            $this->getSumInDirectory($path);
        }

        return $this->sum;
    }

    /**
     * @param string $path
     * @return void
     */
    private function checkDirectory(string $path): void
    {
        if (!is_dir($path)) {
            throw new DirectoryNotExists();
        }

        if (!is_readable($path)) {
            throw new NotReadable();
        }
    }

    /**
     * @param string $path
     * @return void
     */
    private function getSumInDirectory(string $path): void
    {
        $directoryIterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directoryIterator);

        foreach ($iterator as $file) {
            if (!$this->checkFile($file)) {
                continue;
            }

            $this->sum += (float)file_get_contents($file->getPathName());
        }
    }

    /**
     * @param SplFileInfo $file
     * @return bool
     */
    private function checkFile(SplFileInfo $file): bool
    {
        if ($file->getFileName() !== self::SEARCH_FILE) {
            return false;
        }

        if (!$file->isFile()) {
            return false;
        }

        if (!$file->isReadable()) {
            throw new NotReadable();
        }

        return true;
    }
}