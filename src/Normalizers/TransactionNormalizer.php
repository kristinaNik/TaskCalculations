<?php


namespace App\Normalizers;

use App\Entity\Transaction;
use App\TransactionIndexes;
use DateTimeImmutable;
use Evp\Component\Money\Money;

class TransactionNormalizer
{

    public function mapToEntity(array $data): Transaction
    {
        return new Transaction(
            new \DateTime($data[TransactionIndexes::DATE]),
            (int)$data[TransactionIndexes::USER_ID],
            $data[TransactionIndexes::USER_TYPE],
            $data[TransactionIndexes::OPERATION_TYPE],
            new Money($data[TransactionIndexes::OPERATION_AMOUNT], $data[TransactionIndexes::OPERATION_CURRENCY])
        );
    }

}
