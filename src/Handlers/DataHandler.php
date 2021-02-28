<?php


namespace App\Handlers;

use App\Factories\TransactionFactory;
use App\Interfaces\DataInterface;

class DataHandler implements DataInterface
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


    /**
     * @param array $fileData
     * @return array
     */
    private function prepareData(array $fileData): array
    {
        list($date, $userId, $userType, $operationType, $operationAmount, $operationCurrency) = $fileData;

        return [
            'date' => $date,
            'userId' => (int)$userId,
            'userType' => $userType,
            'operationType' => $operationType,
            'operationAmount' => (float) $operationAmount,
            'operationCurrency'=> $operationCurrency,
        ];
    }
}