<?php

namespace App\Command;

use App\Interfaces\DataInterface;
use App\Interfaces\FileInterface;
use App\Services\CalculationService;
use App\Services\ConverterService;
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

    private $service;


    /**
     * CommissionCalculationCommand constructor.
     * @param FileInterface $fileHandler
     * @param DataInterface $dataHandler
     */
    public function __construct(FileInterface $fileHandler, DataInterface $dataHandler, CalculationService $service)
    {
        parent::__construct();
        $this->fileHandler = $fileHandler;
        $this->dataHandler = $dataHandler;
        $this->service = $service;
    }


    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('file_path',InputArgument::REQUIRED, 'path to csv file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = $this->fileHandler->handleCsvData($input->getArgument('file_path'));
        $data =  $this->dataHandler->setDataCollection($file);
        $calculateCommissions = $this->service->calculate($data);

        $io->success($this->displayCalculatedResult($calculateCommissions));

        return Command::SUCCESS;
    }

    /**
     * @todo display calculations
     * @return string
     */
    private function displayCalculatedResult($calculateCommissions)
    {
        return array_values($calculateCommissions);
    }
}
