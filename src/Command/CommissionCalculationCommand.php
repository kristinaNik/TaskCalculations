<?php

namespace App\Command;


use App\Handlers\ApiHandler;
use App\Interfaces\ApiInterface;
use App\Interfaces\FileInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CommissionCalculationCommand extends Command
{
    protected static $defaultName = 'calculate:commission-fee';
    protected static $defaultDescription = 'Calculate commission fee';

    /**
     * @var FileInterface
     */
    private $fileHandler;

    /**
     * @var ApiInterface
     */
    private $apiHandler;


    /**
     * CommissionCalculationCommand constructor.
     * @param FileInterface $fileHandler
     * @param ApiInterface $apiHandler
     */
    public function __construct(FileInterface $fileHandler, ApiInterface $apiHandler)
    {
        parent::__construct();
        $this->fileHandler = $fileHandler;
        $this->apiHandler = $apiHandler;
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
        $this->fileHandler->handleCsvData($input->getArgument('file_path'));
        $this->apiHandler->handleApiData();
        $io->success("calculations");

        return Command::SUCCESS;
    }

    /**
     * @todo display calculations
     * @return string
     */
    private function displayCalculatedResult()
    {

    }
}
