<?php
namespace App\Command;

use App\Handlers\TransactionBuilder;
use App\Interfaces\CalculationInterface;
use App\Interfaces\FileInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CommissionCalculationCommand extends Command
{
    protected static $defaultName = 'calculate:commission';
    protected static $defaultDescription = 'Calculate commission';

    /**
     * @var FileInterface
     */
    private FileInterface $fileHandler;

    /**
     * @var TransactionBuilder
     */
    private TransactionBuilder $transactionBuilder;

    /**
     * @var CalculationInterface
     */
    private CalculationInterface $calculationService;


    /**
     * CommissionCalculationCommand constructor.
     * @param FileInterface $fileHandler
     * @param CalculationInterface $calculationService
     * @param TransactionBuilder $transactionBuilder
     */
    public function __construct(
        FileInterface $fileHandler,
        CalculationInterface $calculationService,
        TransactionBuilder $transactionBuilder
    )
    {
        parent::__construct();
        $this->fileHandler = $fileHandler;
        $this->calculationService = $calculationService;
        $this->transactionBuilder = $transactionBuilder;
    }


    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('file_path',InputArgument::REQUIRED, 'path to csv file')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = $this->fileHandler->handleCsvData($input->getArgument('file_path'));
        $transactions = $this->transactionBuilder->getTransactions($file);
        $convertedTransactions = $this->transactionBuilder->getConvertTransactionHandler($transactions);
        $filterTransactionById = $this->transactionBuilder->getFilterTransactions($file);
        $userTransactions = $this->transactionBuilder->getUserTransactionHandler($convertedTransactions,$filterTransactionById);
        $calculateCommissions = $this->calculationService->calculate($convertedTransactions, $userTransactions);

        $io->success($this->displayCalculatedResult($calculateCommissions));

        return Command::SUCCESS;
    }


    /**
     * @param $calculateCommissions
     *
     * @return array
     */
    private function displayCalculatedResult(array $calculateCommissions): array
    {
        return array_values($calculateCommissions);
    }
}
