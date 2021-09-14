<?php

namespace App\Input;

use Iterator;

interface ReaderInterface
{
    public function getTransactions(string $filename): Iterator;
}
