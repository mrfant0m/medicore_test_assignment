<?php
// src/Command/CalculationCommand.php
namespace App\Command;

use App\Entity\Compensation;
use App\Service\CalculationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Employees;

class CalculationCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CalculationService
     */
    private $calculation;


    protected static $defaultName = 'app:calculation';

    use LockableTrait;

    public function __construct(ContainerInterface $container, CalculationService $calculation)
    {
        $this->container = $container;
        $this->calculation = $calculation;
        $this->entityManager = $this->container->get('doctrine')->getManager();
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Make full recalculation of travel costs.')
            ->setHelp('This command make calculation.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //lock
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return 0;
        }

        try {
            //run recalculation
            $employees = $this->entityManager->getRepository(Employees::class)->findAll();

            if ($employees) {
                foreach ($employees as $employee) {
                    $this->calculation->employeeCalculation($employee);
                }
            }

        } finally {
            //unlock
            $this->release();
        }
    }
}