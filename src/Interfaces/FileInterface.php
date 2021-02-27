<?php


namespace App\Interfaces;


interface FileInterface
{
    /**
     * @param string $args
     *
     * @return array
     */
    public function handleCsvData(string $args): array;
}