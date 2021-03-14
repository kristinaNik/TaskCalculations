<?php
namespace App\Handlers;

use App\Interfaces\FilterTransactionInterface;
use App\Interfaces\TransactionInterface;

class TransactionBuilder
{

    /**
     * @var TransactionInterface
     */
    private TransactionInterface $transactionHandler;


    /**
     * @var FilterTransactionInterface
     */
    private FilterTransactionInterface $filterTransactionHandler;

    private UserTransactionHandler $userTransactionHandler;

    /**
     * TransactionBuilder constructor.
     *
     * @param TransactionInterface $transactionHandler
     * @param FilterTransactionInterface $filterTransactionHandler
     */
    public function __construct(TransactionInterface $transactionHandler, FilterTransactionInterface $filterTransactionHandler, UserTransactionHandler $userTransactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
        $this->filterTransactionHandler = $filterTransactionHandler;
        $this->userTransactionHandler = $userTransactionHandler;
    }

    /**
     * @param $fileData
     *
     * @return array
     */
    public function getTransactions(array $fileData): array
    {
        return $this->transactionHandler->getTransactions($fileData);
    }

    /**
     * @param $fileData
     * @return array
     */
    public function getFilterTransactions(array $fileData): array
    {
        return $this->filterTransactionHandler->filterTransactionById($fileData);
    }

    /**
     * @param $transactions
     * @return array
     */
    public function getConvertTransactionHandler($transactions): array
    {
        return $this->userTransactionHandler->convertTransactions($transactions);
    }

    public function getUserTransactionHandler($transactions,$filterTransactionById): array
    {
        return $this->userTransactionHandler->getUserTransactions($transactions, $filterTransactionById);
    }

}