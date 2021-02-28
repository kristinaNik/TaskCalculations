<?php
namespace App\Handlers;

use App\Factories\TransactionFactory;
use App\Interfaces\TransactionInterface;

class TransactionHandler extends DataHandler implements TransactionInterface
{
    /**
     * @var array
     */
    private $transactions = [];

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