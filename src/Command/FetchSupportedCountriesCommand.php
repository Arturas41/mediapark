<?php

namespace App\Command;

use App\Entity\HolidayApis;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class FetchSupportedCountriesCommand extends Command
{

    protected static $defaultName = 'app:fetch-supported-countries';

    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch supported countries from holidays API and fill it to database')
            ->setHelp('Fetch supported countries from holidays API and fill it to database');

//        $this
//            ->addArgument('name', InputArgument::REQUIRED, 'Select holidays API name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $holidayApisRepository = $this->em->getRepository(HolidayApis::class);
        $holidayApis = $holidayApisRepository->findAll();

        if(empty($holidayApis)){
            throw new \LogicException('no holiday Apis has been found');
        }

        $helper = $this->getHelper('question');

        $names = array_map(function($holidayApi) { return $holidayApi->getName(); }, $holidayApis);

        $question = new ChoiceQuestion(
            'Select holidays API',
            $names
        );

        $bundleName = $helper->ask($input, $output, $question);

        $output->writeln($bundleName);

        return Command::SUCCESS;

    }
}