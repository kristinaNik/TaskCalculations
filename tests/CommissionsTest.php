<?php
namespace App\Tests;

use App\Handlers\ApiHandler;
use App\Handlers\FileHandler;
use App\Handlers\FilterTransactionHandler;
use App\Handlers\TransactionBuilder;
use App\Handlers\TransactionHandler;
use App\Handlers\UserTransactionHandler;
use App\Services\CalculationService;
use App\Services\ConverterService;
use PHPUnit\Framework\TestCase;

class CommissionsTest extends TestCase
{

    /**
     * @var FileHandler
     */
    private FileHandler $file;

    /**
     * @var array
     */
    private array $csvData;

    /**
     * @var TransactionBuilder
     */
    private TransactionBuilder $transactionBuilder;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->file = new FileHandler();
        $this->csvData = $this->file->handleCsvData('src/Data/input.csv');
        $this->transactionBuilder = new TransactionBuilder(new TransactionHandler(), new FilterTransactionHandler(), new UserTransactionHandler(new ConverterService()));
    }

    public function testCsvHandler()
    {
        $this->assertNotEmpty($this->csvData);
        $this->assertIsArray($this->csvData);
    }

    public function testGetTransactions()
    {
        $getTransactions = $this->transactionBuilder->getTransactions($this->csvData);

        $this->assertObjectHasAttribute('date', $getTransactions[0]);
        $this->assertObjectHasAttribute('userId', $getTransactions[0]);
        $this->assertObjectHasAttribute('userType', $getTransactions[0]);
        $this->assertObjectHasAttribute('operationType', $getTransactions[0]);
        $this->assertObjectHasAttribute('operationCurrency', $getTransactions[0]);
    }

    public function testCalculations()
    {
        $getTransactions = $this->transactionBuilder->getTransactions($this->csvData);
        $filterTransactionsById = $this->transactionBuilder->getFilterTransactions($this->csvData);
        $calculationService = new CalculationService();
        $commissions = $calculationService->calculate($getTransactions, $filterTransactionsById);

        $this->assertIsArray($commissions);
        $this->assertSame([
                "3.60 EUR",
                "3.00 EUR",
                "3.00 EUR",
                "0.06 EUR ",
                "1.50 EUR",
                "0.69 EUR",
                "3.00 EUR",
                "0.25 EUR",
                "0.30 EUR",
                "3.00 EUR",
                "0.00 EUR",
                "0.90 EUR",
                "69.82 EUR"
        ], $commissions);
    }

}