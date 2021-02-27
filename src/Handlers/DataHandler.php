<?php


namespace App\Handlers;

use App\Interfaces\DataInterface;
use App\Model\Transaction;

class DataHandler implements DataInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $fileData
     *
     * @return array
     */
    public function setDataCollection($fileData): array
    {
        foreach($fileData as $value) {
            $preparedData = $this->prepareData($value);
            $this->data[] = new Transaction(
                $preparedData['date'],
                (int)$preparedData['userId'],
                $preparedData['userType'],
                $preparedData['operationType'],
                (float)$preparedData['operationAmount'],
                $preparedData['operationCurrency']
            );
        }

        return $this->data;
    }


    /**
     * @param $fileData
     * @return array
     */
    private function prepareData($fileData): array
    {
        list($date, $userId, $userType, $operationType, $operationAmount, $operationCurrency) = $fileData;

        return [
            'date' => $date,
            'userId' => $userId,
            'userType' => $userType,
            'operationType' => $operationType,
            'operationAmount' => $operationAmount,
            'operationCurrency'=> $operationCurrency,
        ];
    }
}