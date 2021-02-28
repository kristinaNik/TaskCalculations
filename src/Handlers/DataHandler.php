<?php


namespace App\Handlers;


class DataHandler
{
    /**
     * @param array $fileData
     * @return array
     */
    public function prepareData(array $fileData): array
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