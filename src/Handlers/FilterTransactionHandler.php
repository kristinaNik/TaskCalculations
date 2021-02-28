<?php
namespace App\Handlers;

use App\Interfaces\FilterTransactionInterface;

class FilterTransactionHandler extends DataHandler implements FilterTransactionInterface
{
    private $transactionById = [];

    /**
     * Filter the transactions by id
     * Get their last date
     *
     * @param $fileData
     * @return array
     */
    public function filterTransactionById(array $fileData): array
    {
        foreach($fileData as $value) {
            $preparedData = $this->prepareData($value);

            $this->transactionById[$preparedData['userId']] = $preparedData['date'];
        }

        return $this->transactionById;
    }

}