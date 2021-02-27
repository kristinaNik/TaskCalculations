<?php


namespace App\Handlers;

use App\Data\DTO\DataDto;
use App\Interfaces\DataInterface;

class DataHandler implements DataInterface
{
    /**
     * @var array
     */
    private $dataDto = [];

    /**
     * @param $fileData
     *
     * @return array
     */
    public function setDtoDataCollection($fileData): array
    {
        foreach($fileData as $value) {
            $preparedData = $this->prepareData($value);
            $this->dataDto[] = new DataDto(
                $preparedData['date'],
                (int)$preparedData['userId'],
                $preparedData['userType'],
                $preparedData['operationType'],
                $preparedData['operationAmount'],
                $preparedData['operationCurrency']
            );
        }

        return $this->dataDto;
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