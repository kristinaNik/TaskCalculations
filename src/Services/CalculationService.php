<?php


namespace App\Services;
use Carbon\Carbon;
use App\Model\Transaction;


class CalculationService
{
    const WITHDRAW = 'withdraw';
    const DEPOSIT = 'deposit';
    const PRIVATE_CLIENT = 'private';
    const BUSINESS_CLIENT = 'business';
    const EUR = 'EUR';

    private $commissionFee = [];
    private $converter;


    /**
     * CalculationService constructor.
     * @param ConverterService $converter
     */
    public function __construct(ConverterService $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param array $transactionData
     * @return array
     */
    public function calculate(array $transactionData): array
    {

        /** @var Transaction $data */
        foreach ($transactionData as $data) {

            if ($data->getOperationType() === self::DEPOSIT) {
                $this->commissionFee[] = ($data->getOperationAmount() * 0.03) / 100;
            }

            if ($data->getOperationType() === self::WITHDRAW && $data->getUserType() === self::PRIVATE_CLIENT) {
                if ($data->getOperationCurrency() != self::EUR) {
                    $amount = ($this->converter->convert($data->getOperationAmount(), $data->getOperationCurrency()) * 0.3) / 100;
                } else {
                    $amount = ($data->getOperationAmount() * 0.3) / 100;
                }

                $this->commissionFee[] = $amount;
            }

            if ($data->getOperationType() === self::WITHDRAW && $data->getUserType() === self::BUSINESS_CLIENT) {
                $this->commissionFee[] = ($data->getOperationAmount() * 0.5) /100;
            }

        }

       return $this->commissionFee;
    }


}