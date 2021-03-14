<?php


namespace App\Handlers;


use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Factories\TransactionFactory;
use App\Factories\UserTransactionFactory;
use App\Interfaces\ConvertInterface;
use App\Model\Transaction;
use App\Services\ConverterService;
use App\Traits\PrepareDataTrait;
use Carbon\Carbon;
use Evp\Component\Money\Money;

class UserTransactionHandler
{
    use PrepareDataTrait;
   private array $userTransaction = [];

   private array $transactions = [];

   private $converterService;

   public function __construct(ConvertInterface $converterService)
   {
       $this->converterService = $converterService;

   }

    public function convertTransactions(array $transactions)
    {

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {

            if ($transaction->getOperationAmount()->getCurrency() != 'EUR') {
                $amount = $this->converterService->convert($transaction->getOperationAmount());
            } else {
                $amount = $transaction->getOperationAmount();
            }

            $this->transactions[]  = TransactionFactory::createTransaction(
                   $transaction->getDate(),
                   $transaction->getUserId(),
                   $transaction->getUserType(),
                   $transaction->getOperationType(),
                    $amount
               );
        }

        return $this->transactions;
    }

    public function getUserTransactions(array $transactions, $filterTransactionById)
    {
        $totalAmount = Money::createZero('EUR');

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $date = Carbon::parse('2016-01-10');

            foreach ($filterTransactionById as $key => $value) {
                if ($key == $transaction->getUserId()) {
                    if ($transaction->getOperationType() === OperationType::WITHDRAW && $transaction->getUserType() === UserType::PRIVATE_CLIENT) {
                        if ($value > 1) {
                            $totalAmount = $totalAmount->add($transaction->getOperationAmount());
                        } else {
                            $totalAmount = $transaction->getOperationAmount();
                        }

                        $this->userTransaction[$transaction->getUserId()] = UserTransactionFactory::createUserTransaction(
                            $transaction->getUserId(),
                            $value,
                            $totalAmount,
                            $transaction->getDate()
                        );
                    }
                }
            }

        }
        return $this->userTransaction;
    }

}