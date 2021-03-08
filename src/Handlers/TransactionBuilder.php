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

    /**
     * TransactionBuilder constructor.
     *
     * @param TransactionInterface $transactionHandler
     * @param FilterTransactionInterface $filterTransactionHandler
     */
    public function __construct(TransactionInterface $transactionHandler, FilterTransactionInterface $filterTransactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
        $this->filterTransactionHandler = $filterTransactionHandler;
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

}