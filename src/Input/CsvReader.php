<?php


namespace App\Input;

use App\TransactionIndexes;
use Iterator;
use SplFileObject;

class CsvReader implements ReaderInterface
{
    public function getTransactions(string $filename): Iterator
    {
        $csvFile = new SplFileObject($filename);
        $csvFile->setFlags(SplFileObject::READ_CSV);

        foreach ($csvFile as $row) {

            if (in_array(null, $row)) {
                continue;
            }

            $transaction = [];

            $transaction[TransactionIndexes::DATE] = $row[0];
            $transaction[TransactionIndexes::USER_ID] = $row[1];
            $transaction[TransactionIndexes::USER_TYPE] = $row[2];
            $transaction[TransactionIndexes::OPERATION_TYPE] = $row[3];
            $transaction[TransactionIndexes::OPERATION_AMOUNT] = $row[4];
            $transaction[TransactionIndexes::OPERATION_CURRENCY] = $row[5];

            yield $transaction;
        }
    }

}
