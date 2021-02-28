<?php


namespace App\Handlers;


class TransactionBuilder
{
    private $transactionHandler;

    private $filterTransactionHandler;

    public function __construct(TransactionHandler $transactionHandler, FilterTransactionHandler $filterTransactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
        $this->filterTransactionHandler = $filterTransactionHandler;
    }

    /**
     * @param $fileData
     * @return array
     */
    public function getTransactions($fileData)
    {
        return $this->transactionHandler->getTransactions($fileData);
    }

    public function getFilterTransactions($fileData)
    {
        return $this->filterTransactionHandler->filterTransactionById($fileData);
    }

}