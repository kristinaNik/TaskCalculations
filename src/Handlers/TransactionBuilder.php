<?php
namespace App\Handlers;

use App\Interfaces\FilterTransactionInterface;
use App\Interfaces\TransactionInterface;

class TransactionBuilder
{

    /**
     * @var TransactionInterface
     */
    private $transactionHandler;


    /**
     * @var FilterTransactionInterface
     */
    private $filterTransactionHandler;

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
     * @return array
     */
    public function getTransactions($fileData): array
    {
        return $this->transactionHandler->getTransactions($fileData);
    }

    /**
     * @param $fileData
     * @return array
     */
    public function getFilterTransactions($fileData): array
    {
        return $this->filterTransactionHandler->filterTransactionById($fileData);
    }

}