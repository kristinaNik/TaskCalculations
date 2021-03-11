<?php
namespace App\Traits;

use Evp\Component\Money\Money;

trait PrepareDataTrait
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
            'operationAmount' =>  $operationAmount,
            'operationCurrency'=> $operationCurrency,
        ];
    }
}