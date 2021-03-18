<?php
namespace App\Iterators;

use Traversable;

class FileIterator extends \IteratorIterator
{

    public function __construct($pathToFile)
    {
        parent::__construct(new \SplFileObject($pathToFile, 'r'));

        $file = $this->getInnerIterator();
        $file->setFlags(\SplFileObject::READ_CSV);
    }
}