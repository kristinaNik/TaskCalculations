<?php
namespace App\Command;

use App\Controller\CalculatorController;
use App\Handlers\TransactionBuilder;
use App\Input\ReaderInterface;
use App\Interfaces\CalculationInterface;
use App\Interfaces\FileInterface;
use App\Normalizers\TransactionNormalizer;
use App\Providers\CommissionRuleProvider;
use App\Providers\ConversionRateProvider;
use App\Services\Calculator;
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
     * @var ReaderInterface
     */
    private $reader;
    /**
     * @var TransactionNormalizer
     */
    private $normalizer;
    /**
     * @var Calculator
     */
    private $calculator;


    public function __construct(
        ReaderInterface $reader,
        TransactionNormalizer $normalizer,
        Calculator $calculator

    ){
        parent::__construct();

        $this->reader = $reader;
        $this->normalizer = $normalizer;
        $this->calculator = $calculator;
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
        $transactions = $this->reader->getTransactions($input->getArgument('file_path'));

        foreach ($transactions as $transaction) {
            $transaction = $this->normalizer->mapToEntity($transaction);
            $commission = $this->calculator->calculate($transaction);
            $output->writeln($commission);
        }

        return Command::SUCCESS;
    }
}
