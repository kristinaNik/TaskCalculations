<?php
namespace App\Tests;

use App\Handlers\ApiHandler;
use App\Handlers\FileHandler;
use App\Handlers\FilterTransactionHandler;
use App\Handlers\TransactionBuilder;
use App\Handlers\TransactionHandler;
use App\Services\CalculationService;
use App\Services\ConverterService;
use PHPUnit\Framework\TestCase;

class CommissionsTest extends TestCase
{

    /**
     * @var FileHandler
     */
    private $file;

    /**
     * @var array
     */
    private $csvData;

    /**
     * @var TransactionBuilder
     */
    private $transactionBuilder;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->file = new FileHandler();
        $this->csvData = $this->file->handleCsvData('src/Data/input.csv');
        $this->transactionBuilder = new TransactionBuilder(new TransactionHandler(), new FilterTransactionHandler());
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
        $calculationService = new CalculationService(new ConverterService(new ApiHandler()));
        $commissions = $calculationService->calculate($getTransactions, $filterTransactionsById);

        $this->assertIsArray($commissions);
        $this->assertSame([
                "3.60",
                "3.00",
                "0.00",
                "0.06",
                "1.50",
                "0.70",
                "3.00",
                "0.25",
                "0.00",
                "3.00",
                "0.00",
                "0.00",
                "69.86"
        ], $commissions);
    }

}