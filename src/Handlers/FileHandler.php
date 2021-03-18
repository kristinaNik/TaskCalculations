<?php
namespace App\Handlers;

use App\Interfaces\FileInterface;
use App\Iterators\FileIterator;

class FileHandler implements FileInterface
{
    /**
     * @param string $file
     *
     * @return array
     * @throws \Exception
     */
    public function handleCsvData(string $file): array
    {
        $fileData = [];

        if ($this->check($file)) {
            $iterator = new FileIterator($file);
            foreach ($iterator as $i => $row) {
                $fileData[] = $row;
            }

        }
        unset($fileData[0]);

        return $fileData;
    }

    /**
     * @param string $file
     *
     * @return bool
     * @throws \Exception
     */
    public function check(string $file): bool
    {
        if (!file_exists($file)) {
            throw new \Exception('File not found');
        }

        return true;
    }
}