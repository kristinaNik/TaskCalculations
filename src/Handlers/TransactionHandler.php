<?php
namespace App\Handlers;

use App\Factories\TransactionFactory;
use App\Interfaces\TransactionInterface;
use App\Traits\PrepareDataTrait;

class TransactionHandler  implements TransactionInterface
{
    use PrepareDataTrait;

    /**
     * @var array
     */
    private array $transactions = [];

    /**
     * Make a collection of array of objects
     * Collect all transactions
     *
     * @param array $fileData
     *
     * @return array
     */
    public function getTransactions(array $fileData): array
    {
        foreach($fileData as $value) {
            $preparedData = $this->prepareData($value);

            $this->transactions[] = TransactionFactory::createTransaction(
                $preparedData['date'],
                $preparedData['userId'],
                $preparedData['userType'],
                $preparedData['operationType'],
                $preparedData['operationAmount'],
                $preparedData['operationCurrency']
            );
        }

        return $this->transactions;
    }
}