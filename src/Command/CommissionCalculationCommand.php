<?php

namespace App\Command;

use App\Interfaces\CalculationInterface;
use App\Interfaces\DataInterface;
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
    private $fileHandler;

    /**
     * @var DataInterface
     */
    private $dataHandler;

    /**
     * @var CalculationInterface
     */
    private $calculationService;

    /**
     * CommissionCalculationCommand constructor.
     *
     * @param FileInterface $fileHandler
     * @param DataInterface $dataHandler
     * @param CalculationInterface $calculationService
     */
    public function __construct(FileInterface $fileHandler, DataInterface $dataHandler, CalculationInterface $calculationService)
    {
        parent::__construct();
        $this->fileHandler = $fileHandler;
        $this->dataHandler = $dataHandler;
        $this->calculationService = $calculationService;
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
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $this->fileHandler->handleCsvData($input->getArgument('file_path'));
        $transactions =  $this->dataHandler->getTransactions($file);
        $calculateCommissions = $this->calculationService->calculate($transactions);

        $io->success($this->displayCalculatedResult($calculateCommissions));

        return Command::SUCCESS;
    }


    /**
     * @param $calculateCommissions
     * @return array
     */
    private function displayCalculatedResult($calculateCommissions)
    {
        return array_values($calculateCommissions);
    }
}
