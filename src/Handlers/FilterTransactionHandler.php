<?php
namespace App\Handlers;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Interfaces\FilterTransactionInterface;
use App\Traits\PrepareDataTrait;
use Carbon\Carbon;

class FilterTransactionHandler implements FilterTransactionInterface
{
    use PrepareDataTrait;

    /**
     * @var array
     */
    private array $transactionById = [];




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
            if ($preparedData['operationType'] === OperationType::WITHDRAW && $preparedData['userType'] === UserType::PRIVATE_CLIENT) {
                $this->transactionById[] = $preparedData['userId'];
            }

        }

        return array_count_values($this->transactionById);
    }

}